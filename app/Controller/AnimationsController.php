<?php


App::uses('AppController', 'Controller');


class AnimationsController extends AppController {


	public $name = 'Animations';


	public $helpers = array('Html', 'Session');

	var $uses = array('Deviceprofile');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('getHistoryByDate');
	}
	public function animation(){
		//$historyData = array();
		//if($this->Session->check('trackHistory'))			
			//$historyData = $this->Session->read('trackHistory');
		//$this->set(compact('historyData'));
	}
	public function index(){
	}
	public function index2() {

		// mysql connection connected
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();

		$conn =  mysql_pconnect( $DB->default['host'], $DB->default['login'], $DB->default['password']  ) or
		die( 'Could not open connection to server' );

		mysql_select_db( 'tracker_devices', $conn ) or
		die( 'Could not select database '. $gaSql['db'] );


		// get params
		$preLat=0;
		$preLng=0;
		$timeDiff=0;
		$startTime=0;
		$endTime=0;


		$deviceid=$_REQUEST['deviceid'];
		//$deviceid='d00149717';
		$historyType=$_REQUEST['historyType'];
		//$historyType='specificDate';
		$historyValue=$_REQUEST['historyValue'];
		//$historyValue='2010-01-12';
		if($deviceid=="")
		{
			$deviceid=$_SESSION['deviceid'];
			//$deviceid='d08007090';
			$historyType=$_SESSION['historyType'];
			//$historyType='specificDate';
			$historyValue=$_SESSION['historyValue'];
		}

		//
		//case 'specificDate':
		$historyValue = explode(",", $historyValue);
		$server_date= $historyValue[0];
		$startHour =$historyValue[1].":00:00";
		$endHour = $historyValue[2].":00:00";

		$query =  "SELECT * FROM ".$deviceid." WHERE server_date='".$server_date."' And (server_time between '".$startHour."' and '".$endHour."') ORDER BY event_number";
		//echo $query;
		//break;

		// render xml
		//echo $query;
		$result = mysql_query($query, $conn);
		//echo mysql_num_rows($result);
		//header("content-type:text/xml");
		//$xml = "<populateData>";
		$output = array();
		$i = 0;

		if(mysql_num_rows($result)!=0)
		{
			while ($row=mysql_fetch_assoc($result))
			{
				$ooutput = array();
					
				$vehicleSpeed=$row['speed'];
				$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');
				$vehicleSpeed=$vehicleSpeed*1.8;
				$vehicleStatus=$row['veh_status'];
				$ignitionStatus=substr($vehicleStatus,5,1);


				if($vehicleSpeed>0) $ignitionStatus=1;

				$recordDate=$row['server_date'];
				$recordTime=$row['server_time'];
				$vehicleLat=$row['latitude'];
				$vehicleLng=$row['longitude'];
				$vehicleAltitude=$row['altitude'];
				$vehicleOdometer=$row['odometer'];

				if($preLat==$vehicleLat && $preLng==$vehicleLng && $preIgn==$ignitionStatus)
				{
					continue;
				}

				$nearaddress = $this->_queryAddress($vehicleLat,$vehicleLng,$conn);
				//echo "address= ".$nearaddress."<br>";
				$preLat=$vehicleLat;
				$preLng=$vehicleLng;
				$preIgn=$ignitionStatus;
					
				$ooutput = array(//'recordDate'=>$recordDate,
							 'recordTime'=>$recordTime,
							 'latLng'=>array($vehicleLat,$vehicleLng),
							 'data'=>$nearaddress,
							 'vehicleSpeed'=>$vehicleSpeed,
							 'ignitionStatus'=>$ignitionStatus,
							 'vehicleOdometer'=>$vehicleOdometer);			
					
				//$xml .= ++$i;
				/*
				 $xml .= '<populateDataDetails	recordDate_xml="'.
					$recordDate.'" recordTime_xml="'.
					$recordTime.'" vehicleLat_xml="'.
					$vehicleLat.'" vehicleLng_xml="'.
					$vehicleLng.'"	nearaddress_xml="'.
					$nearaddress.'"	vehicleSpeed_xml="'.
					$vehicleSpeed.'" 				ignitionStatus_xml="'.
					$ignitionStatus.'" vehicleOdometer_xml="'.
					$vehicleOdometer.'" 	/>';
					*/
				$output[] = $ooutput;
			}

		}
		else
		{
			//$xml .= '<populateDataDetails message_xml="No Record Found" />';
			//echo '<populateDataDetails message_xml="'.$query.'"  />';
		}
		$timeDiff=$this->_travelTime($query, $conn);
		$TotalDistance=$this->_travelDist($query, $conn);

		//$xml .='<populateDataDetails recordDate_xml="'.$recordDate.'" travelTime_xml="'.number_format(($timeDiff/3600), 2, '.', '').'" 	/>';
		//$xml .='<populateDataDetails recordDate_xml="'.$recordDate.'" TotalDistance_xml="'.number_format(($TotalDistance), 2, '.', '').'" 	/>';
		//$xml .="</populateData>";

		return new CakeResponse(array('body' => json_encode(array("recordDate"=>$recordDate,"travelTime"=>number_format(($timeDiff/3600), 2, '.', ''),"TotalDistance"=>number_format(($TotalDistance), 2, '.', ''),"data"=>$output))));
	}

	function _queryAddress($vehicleLat,$vehicleLng,$conn)
	{

		mysql_select_db('tracker_geoinfo',$conn) or die(mysql_error());
		$query ="SELECT *,(((ACOS(SIN((".$vehicleLat."*PI()/180)) *
SIN((lat*PI()/180))+COS((".$vehicleLat."*PI()/180)) *
COS((lat*PI()/180)) * COS(((".$vehicleLng."- lng)
*PI()/180))))*180/PI())) AS distance FROM latlng  ORDER BY distance limit 1";

		$result = mysql_query($query, $conn);
		if(mysql_num_rows($result)!=0)
		{
			$row = mysql_fetch_assoc($result);
			$location=$row['address'];
			$distance=$row['distance'];
			$distance = $distance*60*1.1515*1.609344;
			$distance=number_format($distance, 3, '.', '');
			$location=$distance.' km from '.$location;
			return $location;
		}
		else
		{
			$location='Malaysia';
			return $location;
		}
		//return null;
	}

	function _travelDist($query, $conn)
	{
		$db_name = 'tracker_devices';
		mysql_select_db($db_name,$conn);
		$result= mysql_query($query, $conn);
		$TotalDistancePerDay=0;
		$lat2=0;
		$lng2=0;
		while ( $row = mysql_fetch_assoc( $result ) )
		{
			$recordDate=$row['server_date'];
			$recordDate=strftime("%a %d %b %Y", strtotime($recordDate));
			$lat1=$row['latitude'];
			$lng1=$row['longitude'];
			if(($lat1>0 && $lat2>0 && $lng1>0 && $lng2>0) && ($lat1!=$lat2) && ($lng1!=$lng2))
			{

				$distance=	$this->_distance($lat1, $lng1, $lat2, $lng2);
				//echo "lat1= ".$lat1."   lng1= ".$lng1."   lat2= ".$lat2."   lng2= ".$lng2."<br>";
				//echo "distance= ".$distance."<br>";
				if($distance==NAN)$distance=0;
				if($distance>0) $TotalDistancePerDay=$TotalDistancePerDay+$distance;

			}
			$lat2=$lat1;
			$lng2=$lng1;
		}
		if($TotalDistancePerDay>0) $TotalDistancePerDay=number_format($TotalDistancePerDay, 2, '.', '');
		return $TotalDistancePerDay;
	}
		
	function _distance($lat1, $lng1, $lat2, $lng2)
	{

		$theta = $lng1 - $lng2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		return ($miles * 1.609344);
	}

	function _travelTime($query, $conn)
	{
		//echo $query."<br>";
		$db_name = 'tracker_devices';
		mysql_select_db($db_name,$conn);
		$resultTime= mysql_query($query, $conn);
		$totalEvent = mysql_num_rows($resultTime);
		$timeDiff=0;
		$startTime=0;
		$endTime=0;
		//echo $totalEvent."<br>";
		while ( $row = mysql_fetch_assoc( $resultTime ) )
		{
			//echo  "event_number: ". $event_number."<br>";
			$vehicleStatus=$row['veh_status'];
			$ignitionStatus=substr($vehicleStatus,5,1);
			$recordTime=$row['server_time'];
			$event_number=$row['event_number'];
			if($ignitionStatus==0)
			{
				if($endTime!=0 || $startTime==0 )continue;
				$endTime=$recordTime;
				//echo  "event_number: ". $event_number. "          endTime: ". $endTime."<br>";
			}
			else
			{
				if($startTime!=0)continue;
				$startTime=$recordTime;
				//echo  "event_number: ". $event_number. "          startTime: ". $startTime."<br>";
			}
			if(	$startTime!=0 && $endTime!=0 )
			{
				//echo "startTime: ". $startTime. "          endTime: ". $endTime."<br>";
				$newTimeDiff=strtotime($endTime) - strtotime($startTime);
				if( $newTimeDiff>0)	$timeDiff=$timeDiff+$newTimeDiff;
				$startTime=0;
				$endTime=0;
			}
		}

		if(	$startTime!=0 && $endTime==0 )
		{
			$endTime=$recordTime;
			//echo "Last startTime: ". $startTime. "  event_number: ". $event_number. "    endTime: ". $endTime."<br>";
			$newTimeDiff=strtotime($endTime) - strtotime($startTime);
			if( $newTimeDiff>0)	$timeDiff=$timeDiff+$newTimeDiff;
		}
		//$timeDiff=number_format(($timeDiff/3600), 2, '.', '');
		//$timeDiff=secToHMS($timeDiff);
		return $timeDiff;
	}
}
