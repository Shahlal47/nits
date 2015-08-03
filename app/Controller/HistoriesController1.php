<?php


App::uses('AppController', 'Controller');


class HistoriesController extends AppController {


	public $name = 'Histories';


	public $helpers = array('Html', 'Session');

	var $uses = array('Deviceprofile');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('getHistoryByDate');
	}

	public function index(){
		if($this->Session->check('trackHistory'))
			$this->Session->write('trackHistory', array());
	}
	public function getHistoryByDate() {

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

		$deviceid="d".$_REQUEST['did'];
		$historyType=$_REQUEST['ht'];
		$startDate=$_REQUEST['sd'];
		$endDate=$_REQUEST['ed'];
		
		$startHour= "00:00:00";//$_REQUEST['st'].":00";
		$endHour="23:00:00";//$_REQUEST['et'].":00";
		if($deviceid=="")
		{
			$deviceid=$_SESSION['deviceid'];
			$historyType=$_SESSION['historyType'];
			$historyValue=$_SESSION['historyValue'];
		}

		$query =  "SELECT * FROM ".$deviceid." WHERE CONCAT(server_date,' ',server_time) BETWEEN '".$startDate." ".$startHour."' AND '".$endDate." ".$endHour."' ORDER BY event_number";
		
		$result = mysql_query($query, $conn);

		$output = array();
		$i = 0;

		if(mysql_num_rows($result)>0)
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

				$distance = 0;
				if(($vehicleLat>0 && $vehicleLng>0 && $preLat>0 && $preLng>0) && ($vehicleLat!=$preLat) && ($vehicleLng!=$preLng))
				{
					$distance = $this->_distance($vehicleLat, $vehicleLng, $preLat, $preLng);
				}	
				$ooutput = array(//'recordDate'=>$recordDate,
							 'deviceid'=>$_REQUEST['did'],
							 'serverDateTime'=>$recordDate." ".$recordTime,
							 'vehicleLat'=>$vehicleLat,
							 'vehicleLng'=>$vehicleLng,
							 'nearaddress'=>$nearaddress,
							 'vehicleSpeed'=>$vehicleSpeed,
							 'distance'=>number_format(($distance), 2, '.', ''),
							 'ignitionStatus'=>$ignitionStatus,
							 'vehicleOdometer'=>$vehicleOdometer);			
				
				$preLat=$vehicleLat;
				$preLng=$vehicleLng;
				$preIgn=$ignitionStatus;
				
				$output[] = $ooutput;
			}

			$timeDiff=$this->_travelTime($query, $conn);
			$TotalDistance=$this->_travelDist($query, $conn);
			
			$historyData = array("recordDate"=>$recordDate,"travelTime"=>number_format(($timeDiff/3600), 2, '.', ''),"TotalDistance"=>number_format(($TotalDistance), 2, '.', ''),"data"=>$output);
			$this->Session->write('trackHistory', $historyData);
			return new CakeResponse(array('type' => 'application/json','body' => json_encode($historyData)));
		}
		else
		{
		}
		return new CakeResponse(array('type' => 'application/json','body' => json_encode(array())));
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
