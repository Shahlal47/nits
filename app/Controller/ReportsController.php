<?php
App::uses('AppController', 'Controller');
/**
 * AccountTypes Controller
 *
 * @property AccountType $AccountType
 */
class ReportsController extends AppController {

	public $components = array('RequestHandler');

	var $uses = array('ClientDevice','ClientContactDevice','ClientReport','User');
	var $db_main = 'vts_3';
	var $db_tracker = 'tracker_devices';
	var $db_geo = 'tracker_geoinfo';

	public function index($id=null){
		$this->set('id', $id);
	}

	public function left($id=null){
		$this->autoRender = false;

		$user = $this->User->read(null, $id);
		$client_reports= $this->ClientReport->find('first',
				array(
						'fields' => array('ClientReport.reports'),
						'conditions' => array('ClientReport.client_info_id'=>$user['User']['client_info_id']),
				)
		);

		$client_reports = explode(",",$client_reports['ClientReport']['reports']);
		$data = array();
		foreach ($client_reports as $report){
			$data[$report] = $this->to_camel_case($report,true);
		}
		$this->set('id', $user['User']['id']);
		$this->set('name', $user['User']['username']);
		$this->set('cr', $data);
		$this->render('/LeftContent/report');
	}

	public function to_camel_case($str, $capitalise_first_char = false) {
		if($capitalise_first_char) {
			$str[0] = strtoupper($str[0]);
		}
		$str = str_replace("_", " _", $str);
		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $str);
	}

	public function vehicle_status_report($userId){
		$this->set('id' ,$userId);
	}
	public function vehicle_status_report_list(){

	}

	public function trip_report($userId){
		$this->set('id' ,$userId);
	}
	public function trip_report_list(){

	}

	public function halt_report($userId){
		$this->set('id' ,$userId);
	}
	public function halt_report_list(){

	}

	public function consolidated_report($userId){
		$this->set('id' ,$userId);
	}
	public function consolidated_report_list(){

	}

	public function distance_report($userId){
		$this->set('id' ,$userId);
	}
	public function distance_report_list(){

	}

	public function speed_report($userId){
		$this->set('id' ,$userId);
	}
	public function speed_report_list(){

	}

	public function overspeed_report($userId){
		$this->set('id' ,$userId);
	}
	public function overspeed_report_list(){

	}

	public function alert_report($userId){
		$this->set('id' ,$userId);
	}
	public function alert_report_list(){

	}

	public function fuel_consumption_report($userId){
		$this->set('id' ,$userId);
	}
	public function fuel_consumption_report_list(){

	}

	public function performance_analysis_report($userId){
		$this->set('id' ,$userId);
	}
	public function performance_analysis_report_list(){

	}

	public function profit_calculation_report($userId){
		$this->set('id' ,$userId);
	}
	public function profit_calculation_report_list(){

	}

	public function summery_report($userId){
		$this->set('id' ,$userId);
	}
	public function summery_report_list(){

	}

	public function location_activity_report($userId){
		$this->set('id' ,$userId);
	}
	public function location_activity_report_list(){

	}

	public function vehicle_information_report($userId){
		$this->set('id' ,$userId);
	}
	public function vehicle_information_report_list(){

	}

	public function geofence_report($userId){
		$this->set('id' ,$userId);
	}
	public function geofence_report_list(){

	}

	public function expense_report(){
		$this->set('id' ,$userId);
	}
	public function expanse_report_list(){

	}




	/*public function mileage_report($userId){
		$this->set('id' ,$userId);
	}
	public function mileage_report_list(){

	}

	public function vehicle_uses_report($userId){
	$this->set('id' ,$userId);
	}
	public function vehicle_uses_report_list(){

	}
	public function engine_on_off_report($userId){
	$this->set('id' ,$userId);
	}
	public function engine_on_off_report_list(){

	}*/

	public function ajaxVehicleStatusReport(){

		$deviceids = $this->request->data['VehicleStatusReport']['trackers'];
		$fromdate = $this->request->data['VehicleStatusReport']['fromdate'];
		$status = $this->request->data['VehicleStatusReport']['status'];
		$deviceList = explode(',', $deviceids);

		$fromTime = $this->request->data['VehicleStatusReport']['fromtime'].":00:00";
		$toTime = $this->request->data['VehicleStatusReport']['totime'].":00:00";

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getVehicleStatusReportData($dbc, $deviceList, $fromdate, $fromdate, $fromTime, $toTime, $status);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function ajaxTripReport(){
		$deviceids = $this->request->data['TripReport']['trackers'];
		$fromdate = $this->request->data['TripReport']['fromdate'];
		$todate = $this->request->data['TripReport']['todate'];
		$status = $this->request->data['TripReport']['interval'];
		$deviceList = explode(',', $deviceids);

		$fromTime = $this->request->data['TripReport']['fromtime'].":00:00";
		$toTime = $this->request->data['TripReport']['totime'].":00:00";

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getTripReportData($dbc, $deviceList, $fromdate, $todate, $fromTime, $toTime, $status);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function ajaxHaltReport(){
		$deviceids = $this->request->data['HaltReport']['trackers'];
		$fromdate = $this->request->data['HaltReport']['fromdate'];
		$todate = $this->request->data['HaltReport']['todate'];
		$status = $this->request->data['HaltReport']['halt'];
		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getHaltReportData($dbc, $deviceList, $fromdate, $todate, $status);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	function haltReportGraph(){
		$deviceids = $this->request->data['HaltReport']['trackers'];
		$fromdate = $this->request->data['HaltReport']['fromdate'];
		$todate = $this->request->data['HaltReport']['todate'];
		$status = $this->request->data['HaltReport']['halt'];
		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getHaltReportData($dbc, $deviceList, $fromdate, $todate, $status);
		$this->_closeConnection($dbc);
		$this->set('devices', $result);
		$this->set('title', 'Halt');
	}

	public function ajaxConsolidatedReport(){
		$deviceids = $this->request->data['ConsolidatedReport']['trackers'];
		$fromdate = $this->request->data['ConsolidatedReport']['fromdate'];
		$todate = $this->request->data['ConsolidatedReport']['todate'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getConsolidatedReportData($dbc, $deviceList, $fromdate, $todate);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function ajaxDistanceReport(){
		$deviceids = $this->request->data['DistanceReport']['trackers'];
		$fromdate = $this->request->data['DistanceReport']['fromdate'];
		$todate = $this->request->data['DistanceReport']['todate'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getDistanceReportData($dbc, $deviceList, $fromdate, $todate);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function distanceReportGraph(){
		$deviceids = $this->request->data['DistanceReport']['trackers'];
		$fromdate = $this->request->data['DistanceReport']['fromdate'];
		$todate = $this->request->data['DistanceReport']['todate'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getDistanceReportData($dbc, $deviceList, $fromdate, $todate);
		$this->_closeConnection($dbc);

		$this->set('devices', $result);
		$this->set('title', 'Distance');
		$this->render('/Reports/halt_report_graph');
	}

	public function ajaxSpeedReport(){

		$deviceids = $this->request->data['SpeedReport']['trackers'];
		$fromdate = $this->request->data['SpeedReport']['fromdate'];
		$todate = $this->request->data['SpeedReport']['todate'];
		$status = $this->request->data['SpeedReport']['status'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getSpeedReportData($dbc, $deviceList, $fromdate, $todate, $status);

		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function speedReportGraph(){

		$deviceids = $this->request->data['SpeedReport']['trackers'];
		$fromdate = $this->request->data['SpeedReport']['fromdate'];
		$todate = $this->request->data['SpeedReport']['todate'];
		$status = $this->request->data['SpeedReport']['status'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getSpeedReportData($dbc, $deviceList, $fromdate, $todate, $status);

		$this->_closeConnection($dbc);

		$this->set('devices', $result);
		$this->set('title', 'Speed');
		$this->render('/Reports/halt_report_graph');
	}

	public function ajaxOverspeedReport(){
		$deviceids = $this->request->data['OverspeedReport']['trackers'];
		$fromdate = $this->request->data['OverspeedReport']['fromdate'];
		$todate = $this->request->data['OverspeedReport']['todate'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getOverspeedReportData($dbc, $deviceList, $fromdate, $todate);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function overspeedReportGraph(){
		$deviceids = $this->request->data['OverspeedReport']['trackers'];
		$fromdate = $this->request->data['OverspeedReport']['fromdate'];
		$todate = $this->request->data['OverspeedReport']['todate'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getOverspeedReportData($dbc, $deviceList, $fromdate, $todate);
		$this->_closeConnection($dbc);

		$this->set('devices', $result);
		$this->set('title', 'OverSpeed');
		$this->render('/Reports/halt_report_graph');
	}

	public function ajaxAlertReport(){

		$deviceids = $this->request->data['AlertReport']['trackers'];
		$fromdate = $this->request->data['AlertReport']['fromdate'];
		$todate = $this->request->data['AlertReport']['todate'];
		$status = $this->request->data['AlertReport']['status'];
		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getAlertReportData($dbc, $deviceList, $fromdate, $todate, $status);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function ajaxVehicleInformationReport(){
		$deviceids = $this->request->data['VehicleInformationReport']['trackers'];
		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getVehicleInformationReportData($dbc, $deviceList);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function ajaxFuelConsumptionReport(){
		$deviceids = $this->request->data['FuelConsumptionReport']['trackers'];
		$fromdate = $this->request->data['FuelConsumptionReport']['fromdate'];
		$todate = $this->request->data['FuelConsumptionReport']['todate'];
		$price = $this->request->data['FuelConsumptionReport']['price'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getfuelConsumptionReportData($dbc, $deviceList, $fromdate, $todate, $price);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}

	public function fuelConsumptionGraph(){
		$deviceids = $this->request->data['FuelConsumptionReport']['trackers'];
		$fromdate = $this->request->data['FuelConsumptionReport']['fromdate'];
		$todate = $this->request->data['FuelConsumptionReport']['todate'];
		$price = $this->request->data['FuelConsumptionReport']['price'];

		$deviceList = explode(',', $deviceids);

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getfuelConsumptionReportData($dbc, $deviceList, $fromdate, $todate, $price);
		$this->_closeConnection($dbc);

		$this->set('devices', $result);
		$this->set('title', 'Fuel Consumption');
		$this->render('/Reports/halt_report_graph');
	}

	public function ajaxJourneyReport(){

		$deviceids = $this->request->data['frm']['deviceid'];
		$fromdate = $this->request->data['frm']['fromdate'];
		$todate = $this->request->data['frm']['todate'];

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getJourneyReportData($dbc, $deviceids, $fromdate, $todate);

		$this->_closeConnection($dbc);

		return new CakeResponse(array('body' => json_encode($result)));
	}


	public function ajaxGeofenceReport(){

		$deviceid = $this->request->data['frm']['deviceid'];
		$fromdate = $this->request->data['frm']['fromdate'];
		$todate = $this->request->data['frm']['todate'];

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getGeofenceReportData($dbc, $deviceid, $fromdate, $todate);

		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}
	public function ajaxLocationActivityReport(){

		$deviceid = $this->request->data['frm']['deviceid'];
		$fromdate = $this->request->data['frm']['fromdate'];
		$todate = $this->request->data['frm']['todate'];

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getLocationActivityReportData($dbc, $deviceid, $fromdate, $todate);
		$this->_getLocationActivityReportData($dbc, $deviceid, $driver, $tripInterval, $startDate, $endDate);
		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}
	public function ajaxMileageReport(){

		$deviceid = $this->request->data['frm']['deviceid'];
		$fromdate = $this->request->data['frm']['fromdate'];
		$todate = $this->request->data['frm']['todate'];

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getMileageReportData($dbc, $deviceid, $fromdate, $todate);

		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}
	public function ajaxSummaryReport(){

		$deviceid = $this->request->data['frm']['deviceid'];
		$fromdate = $this->request->data['frm']['fromdate'];
		$todate = $this->request->data['frm']['todate'];

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getSummaryReportData($dbc, $deviceid, $fromdate, $todate);

		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}
	public function ajaxVehicleUsesReport(){

		$deviceid = $this->request->data['frm']['deviceid'];
		$fromdate = $this->request->data['frm']['fromdate'];
		$todate = $this->request->data['frm']['todate'];

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getVehicleUsesReportData($dbc, $deviceid, $fromdate, $todate);

		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}
	public function ajaxEngineOnOffReport(){

		$deviceid = $this->request->data['frm']['deviceid'];
		$fromdate = $this->request->data['frm']['fromdate'];
		$todate = $this->request->data['frm']['todate'];

		// get journey data
		$dbc = $this->_getConnection('dbdevices');
		$result = $this->_getEngineOnOffReportData($dbc, $deviceid, $fromdate, $todate);

		$this->_closeConnection($dbc);

		return new CakeResponse(array('type'=>'application/json', 'body' => json_encode($result)));
	}


	private function _getDeviceProfile($dbc, $deviceid){
		$dbcon = $this->_getConnectionAdmin('vts_3');
		$query = "SELECT * FROM vts_3.client_devices WHERE deviceid='".$deviceid."' ";
		$device_profile = $this->_getRow($dbcon,$query);
		$this->_closeConnection($dbcon);
		return $device_profile;
	}

	private function _getVehicleStatusReportData($dbc, $deviceList, $startDate, $endDate, $startHour,$endHour, $status){
		//
		$reportData = array();
		$i=0;
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}

			$server_date = $startDate;
			$i=0;
			foreach ($deviceList as $deviceid)
			{
				$data = array();
				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];
				$showRegNo=0;
				switch($status)
				{

					case 'All':

						$query =  "SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date between '".$server_date."'and '".$endDate."' And (server_time between '".$startHour."' and '".$endHour."') ORDER BY event_number desc limit 1";
						break;

					case 'Moving':

						$query =  "SELECT * from(SELECT * FROM tracker_devices.d".$deviceid." server_date between '".$server_date."'and '".$endDate."' And (server_time between '".$startHour."' and '".$endHour."') ORDER BY event_number desc limit 1 ) as t1 where SUBSTRING( veh_status, 6, 1 ) = '1' AND CONVERT(speed,DECIMAL(8,2))>0 ";

						break;

					case 'Waiting':

						$query =  "SELECT * from(SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date between '".$server_date."'and '".$endDate."' And (server_time between '".$startHour."' and '".$endHour."') ORDER BY event_number desc limit 1 ) as t1 where SUBSTRING( veh_status, 6, 1 ) = '1' AND CONVERT(speed,DECIMAL(8,2))=0 ";

						break;

					case 'Stop':

						$query =  "SELECT * from(SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date between '".$server_date."'and '".$endDate."' And (server_time between '".$startHour."' and '".$endHour."') ORDER BY event_number desc limit 1 ) as t1 where SUBSTRING( veh_status, 6, 1 ) = '0' AND CONVERT(speed,DECIMAL(8,2))=0 ";

						break;
				}

				$result = $this->_getResult($dbc,$query);
				$totalEvent = count($result);
				$k = 0;
				$values = array();
				if ($result) {
					while ($row = $result->fetch_assoc())
					{
						$vehicleSpeed=$row['speed'];
						$data[$k]['vehicleSpeed']=number_format($vehicleSpeed, 2, '.', '');
						$data[$k]['deviceid'] = $deviceid;
						$vehicleStatus=$row['veh_status'];
						$ignitionStatus=substr($vehicleStatus,5,1);

						$recordEventNumber=$row['event_number'];
						$recordDate=$row['server_date'];
						$recordDate=strftime("%A,%b %d %Y", strtotime($recordDate));
						$recordTime=$row['server_time'];
						$lastRecordTime = time()+6*60*60;
						$groupRecordTime=strtotime($recordDate ." ". $recordTime );
						$timeDiff = $lastRecordTime-$groupRecordTime;

						$data[$k]['last_update_date'] = date("Y-m-d H:i:s", $lastRecordTime);
						$data[$k]['current_update_date'] = date("Y-m-d H:i:s", $groupRecordTime);
						//$data['current_date'] =

						$vehicleLat=$row['latitude'];
						$vehicleLng=$row['longitude'];
						$vehicleAltitude=$row['altitude'];
						$vehicleOdometer=$row['odometer'];
						$data[$k]['nearaddress']=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);

						if($ignitionStatus==1 && $vehicleSpeed>"0.00")
						{
							$data[$k]['motion']="Moving";
							$data[$k]['engine_status']="On";
						}
						elseif($ignitionStatus==1 && $vehicleSpeed=="0.00")
						{
							$data[$k]['motion']="Waiting";
							$data[$k]['engine_status']="On";
						}
						else
						{
							$data[$k]['motion']="Stopped";
							$data[$k]['engine_status']="Off";
						}
						$reportData[$registration_number] = $data[$k];
						$k++;
						$data[$k]['serial'] = $i+1;
						$data[$k]['reg_number'] = $registration_number;

						$vehicleSpeed=$row['speed'];
						$data[$k]['vehicleSpeed']=number_format($vehicleSpeed, 2, '.', '');

						$vehicleStatus=$row['veh_status'];
						$ignitionStatus=substr($vehicleStatus,5,1);

						$recordEventNumber=$row['event_number'];
						$recordDate=$row['server_date'];
						$recordDate=strftime("%A,%b %d %Y", strtotime($recordDate));
						$recordTime=$row['server_time'];
						$lastRecordTime = time()+6*60*60;
						$groupRecordTime=strtotime($recordDate ." ". $recordTime );
						$timeDiff = $lastRecordTime-$groupRecordTime;

						$data[$k]['last_update_date'] = date("Y-m-d H:i:s", $lastRecordTime);
						$data[$k]['current_update_date'] = date("Y-m-d H:i:s", $groupRecordTime);
						//$data['current_date'] =

						$vehicleLat=$row['latitude'];
						$vehicleLng=$row['longitude'];
						$vehicleAltitude=$row['altitude'];
						$vehicleOdometer=$row['odometer'];
						$data[$k]['nearaddress']=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);

						if($ignitionStatus==1 && $vehicleSpeed>"0.00")
						{
							$data[$k]['motion']="Moving";
							$data[$k]['engine_status']="On";
						}
						elseif($ignitionStatus==1 && $vehicleSpeed=="0.00")
						{
							$data[$k]['motion']="Waiting";
							$data[$k]['engine_status']="On";
						}
						else
						{
							$data[$k]['motion']="Stopped";
							$data[$k]['engine_status']="Off";
						}
						$values[$k] = $data[$k];
						$k++;
						$i++;
					}
					$reportData[$registration_number] = $values;
				}
			}
		}
		return $reportData;
	}

	//Trip Reports Data
	private function _getTripReportData($dbc, $deviceList, $startDate, $endDate, $startHour,$endHour, $status){
		//
		$reportData = array();
		$i=0;
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}

			$server_date = $startDate;
			$i=0;
			foreach ($deviceList as $deviceid)
			{
				$data = array();
				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];
				$showRegNo=0;
				$preLat=0;
				$preLng=0;
				$preDate=0;
				$recordTimeWithInterval=0;
				$query =  "SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date >='".$startDate."' AND  server_date <='".$endDate."' AND event_number NOT IN (SELECT event_number FROM tracker_devices.d".$deviceid." WHERE server_date ='".$startDate."' AND server_time<'".$startHour."' ) AND event_number NOT IN (SELECT event_number FROM tracker_devices.d".$deviceid." WHERE server_date ='".$endDate."' AND server_time>'".$endHour."'  ) ORDER BY event_number ";
				//$queryCount =  "SELECT count(*) FROM tracker_devices.d".$deviceid." WHERE server_date >='".$startDate."' AND  server_date <='".$endDate."' AND event_number NOT IN (SELECT event_number FROM tracker_devices.d".$deviceid." WHERE server_date ='".$startDate."' AND server_time<'".$startHour."' ) AND event_number NOT IN (SELECT event_number FROM tracker_devices.d".$deviceid." WHERE server_date ='".$endDate."' AND server_time>'".$endHour."'  ) ORDER BY event_number ";

				$result = $this->_getResult($dbc,$query);

				$totalEvent = $result->num_rows;
				$k = 0;
				$values = array();
				$lastK = 0;
				$totalDistance = 0;
				if ($result) {
					while ($row = $result->fetch_assoc())
					{

						$recordDate=$row['server_date'];
						$recordTime=$row['server_time'];
						if($preDate!=$recordDate) $recordTimeWithInterval=0;
						if(strtotime($recordTime) > $recordTimeWithInterval)
						{
								
							$data[$k]['regNumber'] = $registration_number;
							$recordTimeWithInterval=strtotime($recordTime)+60*$status;

							$preDate=$recordDate;
								
							$event_number=$row['event_number'];
							$vehicleSpeed=$row['speed'];
							$data[$k]['vehicleSpeed']=number_format($vehicleSpeed, 2, '.', '');
							$data[$k]['fdate'] = $recordDate.' '.$recordTime;
							$data[$k]['date']=strftime("%a %d %b %Y", strtotime($recordDate)).' '.$recordTime;
							$data[$k]['vehicleLat']=$row['latitude'];
							$data[$k]['vehicleLng']=$row['longitude'];
							$vehicleStatus=$row['veh_status'];
							$ignitionStatus=substr($vehicleStatus,5,1);
								
							if($preLat==$data[$k]['vehicleLat'] && $preLng==$data[$k]['vehicleLng'])
							{
								$totalEvent--;
								continue;
							}

							$data[$k]['addr']=$this->_queryAddress($data[$k]['vehicleLat'],$data[$k]['vehicleLng'],$dbc);
							$distance=0;
							if($data[$k]['vehicleLat']>0 && $data[$k]['vehicleLng']>0 && $preLat>0 && $preLng>0)
							{
								$distance=$this->_distance($data[$k]['vehicleLat'], $data[$k]['vehicleLng'], $preLat, $preLng);
								$data[$k]['p2pValue']=number_format($distance, 2, '.', '');
							}else{
								$data[$k]['p2pValue']=0;
							}
							$preLat=$data[$k]['vehicleLat'];
							$preLng=$data[$k]['vehicleLng'];

							if($ignitionStatus==1 && $vehicleSpeed>"0.00")
							{
								$data[$k]['motion']="Moving";
								$data[$k]['status']="On";

							}
							elseif($ignitionStatus==1 && $vehicleSpeed=="0.00")
							{
								$data[$k]['motion']="Waiting";
								$data[$k]['status']="On";

							}
							else
							{
								$data[$k]['motion']="Stopped";
								$data[$k]['status']="Off";

							}
							$data[$k]['total_dist'] = $this->_travelDistance($dbc, $query);

							$values[$k] = $data[$k];
							$k++;
							$i++;
						}
					}
					$reportData[$registration_number] = $values;
				}
			}
		}
		return $reportData;
	}


	private function _getHaltReportData($dbc, $deviceList, $beginDate, $endDate, $halt){
		//
		$reportData = array();
		$i=0;
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}

			$server_date = $beginDate;
			$i=0;
			$daysDifference=$this->_daysDifference($endDate, $beginDate);
			foreach ($deviceList as $deviceid)
			{
				$data = array();
				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];
				$showRegNo=0;

				for($d = 0; $d<=$daysDifference;$d++)
				{

					$query =  "SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date ='".$server_date."' order by event_number ";
						
					$TotalHaltTime=0;
					$startTime=0;
					$endTime=0;
					$NoOfHalts=0;
					$lastStartTime=0;
					$createRow=false;

					$result = $this->_getResult($dbc,$query);
					$totalEvent = count($result);
					$k = 0;
					$values = array();
					if ($result) {
						while ( $row = $result->fetch_assoc() )
						{
							$vehicleSpeed=$row['speed'];
							$event_number=$row['event_number'];
							$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');

							$recordDate=$row['server_date'];
							$recordTime=$row['server_time'];

							$data[$k]['record_date'] = $recordDate;
							$recordDate=strftime("%a %d %b %Y", strtotime($recordDate));

							$vehicleLat=$row['latitude'];
							$vehicleLng=$row['longitude'];


							$haltTime=0;
							if($vehicleSpeed>0)
							{
								$startTime=$recordTime;
									
								if($endTime!=0)
								{
									$newTimeDiff=strtotime($startTime) - strtotime($lastStartTime);

									if( $newTimeDiff>300 && $newTimeDiff<5400)
									{
										$haltTime=$newTimeDiff;
										$TotalHaltTime=$TotalHaltTime+$haltTime;
										$NoOfHalts++;
									}
									$startTime=0;
									$endTime=0;
									$lastStartTime=0;
									$createRow=true;
								}
								else
								{
									$createRow=false;
								}
								$lastStartTime=$startTime;
									
							}
							else
							{
								if($startTime==0 )continue;
								$endTime=$recordTime;
								continue;
									
							}
							$haltTime=number_format(($haltTime/60), 2, '.', '');

							if ($haltTime > 0 && $haltTime >= $halt) {
								$data[$k]['lat'] = $vehicleLat;
								$data[$k]['lng'] = $vehicleLng;
								$data[$k]['addr'] = $this->_queryAddress($vehicleLat, $vehicleLng, $dbc);
								$data[$k]['duration'] = $haltTime;
								$data[$k]['date'] = $recordDate;
								$data[$k]['info'] = '';
								$data[$k]['regNumber'] = $registration_number;
								$data[$k]['total_halt'] = "Date : ".$recordDate.' Total Halt Time : '.$this->_secToHMS($TotalHaltTime).' No of Halt : '.$NoOfHalts;
								$values[$k] = $data[$k];
								$k++;
								$i++;
							}

						}
						$reportData[$registration_number] = $values;
					}
					$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
				}
			}
		}
		return $reportData;
	}

	//Consolidated report data
	private function _getConsolidatedReportData($dbc, $deviceList, $beginDate, $endDate){
		//
		$reportData = array();
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
			$daysDifference=$this->_daysDifference($endDate,$beginDate);
			foreach ($deviceList as $deviceid)
			{
				$server_date = $beginDate;
				$data = array();

				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];
				$showRegNo=0;

				for($k = 0; $k <= $daysDifference; $k++)
				{
					$queryDist="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' ";
					$queryMaxSpeed="SELECT MAX(CONVERT(speed,DECIMAL(8,2))) AS maxSpeed FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' ";
					$queryAvgSpeed="SELECT AVG(CONVERT(speed,DECIMAL(8,2))) AS avgSpeed FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' AND CONVERT(speed,DECIMAL(8,2))>0 ";
					$queryTravelTime="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' ORDER BY event_number ASC ";
					$queryTotalStop="SELECT msg_id FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' and substring(veh_status,6,1)='0' and msg_id='0002'  ";
						
					$dist = $this->_travelDistance($dbc, $queryDist);

					if (!empty($result)){
						$result = $this->_getResult($dbc,$queryMaxSpeed);
						$row = $result->fetch_assoc();
						$maxSpeed=$row['maxSpeed'];
					}
					else{
						$maxSpeed = '';
					}
						
					if (!empty($result)){
						$result = $this->_getResult($dbc,$queryAvgSpeed);
						$row = $result->fetch_assoc();
						$avgSpeed=$row['avgSpeed'];
						$avgSpeed=number_format($avgSpeed, 2, '.', '');
					}
					else{
						$maxSpeed = '';
					}
						
					$travelTime = $this->_travelTime($dbc, $queryTravelTime);
						
					$stopTime=24*60*60 - $travelTime ;
					//$totalStopTime=$totalStopTime+$stopTime;
						
					$travelTime=$this->_secToHMS($travelTime);
					$stopTime=$this->_secToHMS($stopTime);
						
					$result = $this->_getResult($dbc,$queryTotalStop);
					$totalStop = count($result);
						
					//Prepare Data to display
					$data[$k]['deviceid'] = $deviceid;
					$data[$k]['reg_number'] = $registration_number;
					$data[$k]['date'] = strftime("%a %d %b %Y", strtotime($server_date));;
					$data[$k]['travel_time'] =$travelTime;
					$data[$k]['stop_time'] = $stopTime;
					$data[$k]['distance'] = $dist;
					$data[$k]['max_speed'] = $maxSpeed;
					$data[$k]['avg_speed'] = $avgSpeed;
					$data[$k]['total_stops'] = $totalStop;
					if ($totalStop > 0) {
						$data[$k]['avg_stop_length'] = number_format(($dist/$totalStop), 2, '.', '');
					}
					else{
						$data[$k]['avg_stop_length'] = 0;
					}
					//todo
					$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
					$values[$k] = $data[$k];
				}
				$reportData[$registration_number] = $values;
			}
		}
		return $reportData;
	}

	private function _getDistanceReportData($dbc, $deviceList, $beginDate, $endDate){
		//
		$reportData = array();
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
				
			$daysDifference=$this->_daysDifference($endDate,$beginDate);
			foreach ($deviceList as $deviceid)
			{
				$server_date = $beginDate;
				$data = array();

				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];
				$totalDist = 0;
				for($k = 0; $k <= $daysDifference; $k++)
				{
					$query =  "SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date ='".$server_date."' order by event_number ";

					$TotalDistancePerDay=0;
					$lat2=0;
					$lng2=0;
						
					$result = $this->_getResult($dbc, $query);
						
					if($result){
						while ( $row = $result->fetch_assoc())
						{
							$lat1=$row['latitude'];
							$lng1=$row['longitude'];
							if(($lat1>0 && $lat2>0 && $lng1>0 && $lng2>0) && ($lat1!=$lat2) && ($lng1!=$lng2))
							{
								$distance =	$this->_distance($lat1, $lng1, $lat2, $lng2);
								if($distance==NAN)$distance=0;
								if($distance>0 && $distance<10) $TotalDistancePerDay=$TotalDistancePerDay+$distance;
							}
							$lat2=$lat1;
							$lng2=$lng1;
						}
					}
						
					//Prepare Data to display
					$data[$k]['reg_number'] = $registration_number;
					$data[$k]['date'] = strftime("%a %d %b %Y", strtotime($server_date));
					$data[$k]['distance'] = number_format($TotalDistancePerDay, 2, '.', ''). " Kms";
					$totalDist +=number_format($TotalDistancePerDay, 2, '.', '');
					$data[$k]['total_dist'] = number_format($totalDist, 2, '.', ''). " Kms";
					$data[$k]['d_dist'] = number_format($TotalDistancePerDay, 2, '.', '');
						
					$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
					$values[$k] = $data[$k];
				}
				$reportData[$registration_number] = $values;
			}
		}
		return $reportData;
	}

	private function _getOverspeedReportData($dbc, $deviceList, $beginDate, $endDate){
		//
		$reportData = array();
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
				
			$daysDifference=$this->_daysDifference($endDate,$beginDate);
			foreach ($deviceList as $deviceid)
			{
				$values = array();
				$server_date = $beginDate;
				$data = array();

				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];
				$speed_limit=$rowDeviceInfo['speed_limit'];
				if($speed_limit=="")$speed_limit=80;

				for($k = 0; $k <= $daysDifference; $k++)
				{
					$query =  "SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date between '".$server_date."' '".$endDate."' and  and speed >".$speed_limit/1.8." order by event_number ";

					$result = $this->_getResult($dbc, $query);
					$totalRow = $result->num_rows;

					if($result && $totalRow > 0){
						while ( $row = $result->fetch_assoc())
						{
							$vehicleSpeed=$row['speed'];
							$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');

							$vehicleLat=$row['latitude'];
							$vehicleLng=$row['longitude'];

							if($vehicleSpeed > 100)
							{
								$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
								//Prepare Data to display
								$data[$k]['reg_number'] = $registration_number;
								$data[$k]['date'] = strftime("%a %d %b %Y", strtotime($server_date));
								$data[$k]['speed'] = $vehicleSpeed * 1.8;
								$data[$k]['addr'] = $nearaddress;
								$data[$k]['info'] = $vehicleLat.'::'.$vehicleLng;

								$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
								$values[$k] = $data[$k];
							}
						}
					}
					else{
						$data[$k]['reg_number'] = $registration_number;
						$data[$k]['date'] = strftime("%a %d %b %Y", strtotime($server_date));
						$data[$k]['speed'] = "-";
						$data[$k]['addr'] = "-";
						$data[$k]['info'] = "No Record";

						$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
						$values[$k] = $data[$k];
					}
				}
				if (isset($values) && !empty($values)) {
					$reportData[$registration_number] = $values;
						
				}
			}
		}
		return $reportData;
	}

	private function _getAlertReportData($dbc, $deviceList, $beginDate, $endDate, $status){
		//
		$reportData = array();
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
				
			$daysDifference=$this->_daysDifference($endDate,$beginDate);
			foreach ($deviceList as $deviceid)
			{
				$values = array();
				$data = array();
				$server_date = $beginDate;
				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];
				$speed_limit=$rowDeviceInfo['speed_limit'];
				$showRegNo=0;
				for($k = 0; $k <= $daysDifference; $k++)
				{
					switch($status)
					{
						case 'All':

							$query =  "SELECT * FROM d".$deviceid." WHERE server_date ='".$server_date."' and (speed >".$speed_limit/1.8." or msg_id='0005' or msg_id='000B') order by event_number ";

							$queryOverSpeed =  "SELECT * FROM ".$deviceid." WHERE server_date ='".$server_date."' and speed >".$speed_limit/1.8." order by event_number ";
							$resultOverSpeed = $this->_getResult($dbc,$queryOverSpeed);
							$totalOverSpeed = count($resultOverSpeed);
								
							$queryEmergencySwitchPressed =  "SELECT * FROM ".$deviceid." WHERE server_date= '".$server_date."' and msg_id='0005' ORDER BY event_number";
							$resultEmergencySwitchPressed = $this->_getResult($dbc,$queryEmergencySwitchPressed);
							$totalEmergencySwitchPressed = count($resultEmergencySwitchPressed);

							$queryMainPowerFailure =  "SELECT * FROM ".$deviceid." WHERE server_date= '".$server_date."' and msg_id='000B' ORDER BY event_number";
							$resultMainPowerFailure = $this->_getResult($dbc,$queryMainPowerFailure);
							$totalMainPowerFailure = count($resultMainPowerFailure);

							break;
						case 'Overspeed':
							$query =  "SELECT * FROM d".$deviceid." WHERE server_date ='".$server_date."' and speed >".$speed_limit/1.8." order by event_number ";
							break;
						case 'EmergencySwitchPressed':
							$query =  "SELECT * FROM d".$deviceid." WHERE server_date= '".$server_date."' and msg_id='0005' ORDER BY event_number";
							break;
						case 'MainPowerFailureAlert':
							$query =  "SELECT * FROM d".$deviceid." WHERE server_date= '".$server_date."' and msg_id='000B' ORDER BY event_number";
							break;
					}
					//echo $query;

					$result = $this->_getResult($dbc,$query);
					$totalEvent = $result->num_rows;
					$i=0;
					if ($result && $totalEvent > 0) {
						while ($row = $result->fetch_assoc())
						{
								
							$vehicleSpeed=$row['speed'];
							$recordDate=$row['server_date'];
							$recordTime=$row['server_time'];
							$recordDate=strftime("%a %d %b %Y", strtotime($recordDate)).' '.$recordTime;
								
							$vehicleLat=$row['latitude'];
							$vehicleLng=$row['longitude'];
								
							$msg_info=$row['msg_info'];
							$msg_id=$row['msg_id'];

							// Prepare data to display
							$data[$k]['reg_number'] = $registration_number;
								
							if($status=="Overspeed")
							{
								$data[$k]['total_info'] = "Total Overspeed: ". $totalEvent ."<br>";
							}
							else if($status=="EmergencySwitchPressed")
							{
								$data[$k]['total_info'] = "Total Emergency Switch Pressed: ". $totalEvent ."<br>";
							}
							else if($status=="MainPowerFailureAlert")
							{
								$data[$k]['total_info'] = "Total Main Power Failure: ". $totalEvent ."<br>";
							}
							else
							{
								$data[$k]['total_info'] = "Total Overspeed: ". $totalOverSpeed ."<br> Total Emergency Switch Pressed: ". $totalEmergencySwitchPressed ."<br> Total Main Power Failure: ". $totalMainPowerFailure ."<br>";
							}
								
							$data['record_date'] = $recordDate;
							$data['f_date'] = $recordDate.' '.$recordTime;

							if($msg_id=='0005')
							{
								$data[$k]['description'] = "Emergency Switch Pressed";
							}
							else if($msg_id=='000B')
							{
								$data[$k]['description'] = "Main Power Failure Alert";
							}
							else
							{
								$data[$k]['description'] = "Overspeed Registered";
							}

							$data[$k]['address'] = $this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
								
							$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
							$values[$k] = $data[$k];
						}
					}
					else{
						$data[$k]['reg_number'] = $registration_number;
						$data[$k]['address'] = '-';
						$data[$k]['description'] = "-";
						$data[$k]['total_info'] ='No Record';
						$data[$k]['date'] =strftime("%a %d %b %Y", strtotime($server_date));;
						$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
						$values[$k] = $data[$k];
					}
				}
				if (isset($values) && !empty($values)) {
					$reportData[$registration_number] = $values;
				}
			}
		}
		return $reportData;
	}

	private function _getVehicleInformationReportData($dbc, $deviceList){
		//
		$reportData = array();
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
				
			foreach ($deviceList as $deviceid)
			{
				$data = array();

				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);

				$registration_number=$rowDeviceInfo['name'];
				$data[0]['reg_number'] = $registration_number;

				$speed_limit=$rowDeviceInfo['speed_limit'];
				if($speed_limit=="")$speed_limit=80;
				$data[0]['speed'] = $speed_limit;

				$fuel_consumption=$rowDeviceInfo['fuel_consumption'];
				if($fuel_consumption=='') $fuel_consumption=10;
				$data[0]['fuel'] =$fuel_consumption;

				$query = "Select expire_date from client_device_subscriptions as cds where cds.id ='".$rowDeviceInfo['client_device_subscription_id']."'";

				$result = $this->_getResult($dbc, $query);
				if(!empty($result)){
					$row = $result->fetch_assoc();
					$data[0]['expiry_date'] = strftime("%a %d %b %Y", strtotime($row['expire_date']));
				}
				else{
					$data[0]['expiry_date'] = '';
				}
				$data[0]['mob_no'] = $rowDeviceInfo['mob_no'];
				$data[0]['deviceid'] = $deviceid;
				$reportData[$deviceid] = $data;
			}
				
		}
		return $reportData;
	}

	private function _getFuelConsumptionReportData($dbc, $deviceList, $beginDate, $endDate, $price){
		//
		$reportData = array();
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
				
			$daysDifference=$this->_daysDifference($endDate,$beginDate);
				
			foreach ($deviceList as $deviceid)
			{
				$server_date = $beginDate;
				$data = array();

				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
					
				$registration_number=$rowDeviceInfo['name'];

				$fuel_consumption=$rowDeviceInfo['fuel_consumption'];
				if($fuel_consumption=='') $fuel_consumption=10;
				if($price!='default') $fuel_consumption=$price;

				$d=0;
				$tracker=0;
				$i=0;
				$TotalDistance=0;
				$totalTravelTime=0;
				$totalStopTime=0;
				$totalFuel = 0;

				for($k = 0; $k <= $daysDifference; $k++)
				{

					$queryDist="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' ";
					$queryMaxSpeed="SELECT MAX(CONVERT(speed,DECIMAL(8,2))) AS maxSpeed FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' ";
					$queryAvgSpeed="SELECT AVG(CONVERT(speed,DECIMAL(8,2))) AS avgSpeed FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' AND CONVERT(speed,DECIMAL(8,2))>0 ";
					$queryTravelTime="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' ORDER BY event_number ASC ";
						
					$dist = $this->_travelDistance($dbc, $queryDist);
						
					$result = $this->_getResult($dbc,$queryMaxSpeed);
					if(!empty($result)){
						$row = $result->fetch_assoc();
						$maxSpeed=$row['maxSpeed'];
					}
					else{
						$maxSpeed = '';
					}
					if(!empty($result)){
						$result = $this->_getResult($dbc,$queryAvgSpeed);
						$row = $result->fetch_assoc();
						$avgSpeed=$row['avgSpeed'];
						$avgSpeed=number_format($avgSpeed, 2, '.', '');
					}
					else{
						$avgSpeed = '';
					}

					$travelTime = $this->_travelTime($dbc, $queryTravelTime);

					$stopTime=24*60*60 - $travelTime ;

					$totalTravelTime = $totalTravelTime + $travelTime;
					$totalStopTime = $totalStopTime+$stopTime;

					$travelTime=$this->_secToHMS($travelTime);
					$stopTime=$this->_secToHMS($stopTime);

					$fuel = number_format(($dist/$fuel_consumption), 2, '.', '');
						
					$TotalDistance = $TotalDistance + $dist;
					$totalFuel = $totalFuel + $fuel;
						
					if ($k > 1 && $k == $daysDifference) {
						$data[$k]['date'] = "Total :";
						$data[$k]['travel_time'] =$this->_secToHMS($totalTravelTime);
						$data[$k]['stop_time'] = $this->_secToHMS($totalStopTime);
						$data[$k]['distance'] = $TotalDistance;
						$data[$k]['fuel'] = $totalFuel;
						$data[$k]['max_speed'] = "-";
						$data[$k]['avg_speed'] = "-";
					}
					else{
						$data[$k]['date'] = $server_date;
						$data[$k]['travel_time'] =$travelTime;
						$data[$k]['stop_time'] = $stopTime;
						$data[$k]['distance'] = $dist;
						$data[$k]['fuel'] = $fuel;
						$data[$k]['max_speed'] = $maxSpeed * 1.8;
						$data[$k]['avg_speed'] = $avgSpeed * 1.8;
					}
					$data[$k]['reg_number'] = $registration_number;
						
					$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
					$values[$k] = $data[$k];
				}
				$reportData[$registration_number] = $values;
			}
		}
		return $reportData;
	}


	private function _getJourneyReportData($dbc, $deviceid, $startDate, $endDate){
		$query = "SELECT * FROM ".$this->db_tracker.".d".$deviceid." WHERE server_date BETWEEN '".$startDate."' AND '".$endDate."' order by event_number";
		$result = $this->_getResult($dbc,$query);
		$journeyData = array();
		if(count($result)>0){

			$preLat=0;
			$preLng=0;
			$preIgnitionStatus=5;
			$preTime="00:00:00";
			$first_time_eng_on=false;
			$recordTimeWithInterval=0;

			$startDate=date('Y-m-d', strtotime('+1 day', strtotime(date($startDate))));
			$i = 0;
			while ($row = $result->fetch_assoc())
			{
				$recordDate=$row['server_date'];
				$recordTime=$row['server_time'];
				$event_number=$row['event_number'];
				$vehicleSpeed=$row['speed'];
				$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');

				$vehicleLat=$row['latitude'];
				$vehicleLng=$row['longitude'];
				$vehicleStatus=$row['veh_status'];
				$ignitionStatus=substr($vehicleStatus,5,1);
				if($first_time_eng_on==false)
				{
					if($ignitionStatus==1)
					{
						$first_time_eng_on=true;
						$preTime=$recordTime;
						$preLat=$vehicleLat;
						$preLng=$vehicleLng;
						$preIgnitionStatus=$ignitionStatus;

					}
					else
					{
						continue;
					}
				}
				else
				{
					if(($preLat==$vehicleLat && $preLng==$vehicleLng)||( $preIgnitionStatus==$ignitionStatus))
					{
						continue;
					}


					//$duration= getTimeDiff($preTime,$recordTime);
					$duration=$this->_timeDiff($recordDate." ".$preTime,$recordDate." ".$recordTime);

					$from=$this->_queryAddress($preLat,$preLng,$dbc);
					$to=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);

					$mileage=$this->_distance($vehicleLat, $vehicleLng, $preLat, $preLng);
					$fuelCost=($mileage*1.8)/10;

					$journeyData[$i]['from'] = $from;
					$journeyData[$i]['to'] = $to;
					$journeyData[$i]['preTime'] = $recordDate.' '.$preTime;
					$journeyData[$i]['recordTime'] = $recordDate.' '.$recordTime;
					$journeyData[$i]['duration'] = $duration;
					$journeyData[$i]['mileage'] = $mileage;
					$journeyData[$i]['fuel'] = $fuelCost;


					$preLat=$vehicleLat;
					$preLng=$vehicleLng;
					$preIgnitionStatus=$ignitionStatus;
					$preTime=$recordTime;
					$first_time_eng_on=false;
					$i++;
				}

			}
		}
		//pr($journeyData);
		return $journeyData;

	}
	private function _getLocationActivityReportData($dbc, $deviceid, $driver, $tripInterval, $startDate, $endDate){
		$query = "SELECT * FROM ".$this->db_tracker.".d".$deviceid." WHERE server_date BETWEEN '".$startDate."' AND '".$endDate."' order by event_number";
		//echo $query;
		$result = $this->_getResult($dbc,$query);
		//pr($results);
		$locationActivity = array();
		if(count($result)>0){

			$preLat=0;
			$preLng=0;
			$recordTimeWithInterval=0;

			$startDate=date('Y-m-d', strtotime('+1 day', strtotime(date($startDate))));
			$i = 0;
			//pr($result);
			while ($row = $result->fetch_assoc())
			{
				$recordDate=$row['server_date'];
				$recordTime=$row['server_time'];
				if(strtotime($recordTime) > $recordTimeWithInterval)
				{
					$recordTimeWithInterval=strtotime($recordTime)+60*$tripInterval;
					$event_number=$row['event_number'];
					$vehicleSpeed=$row['speed'];
					$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');

					$recordDate=strftime("%a %d %b %Y", strtotime($recordDate));
					$vehicleLat=$row['latitude'];
					$vehicleLng=$row['longitude'];
					$vehicleStatus=$row['veh_status'];
					$ignitionStatus=substr($vehicleStatus,5,1);
					if($preLat==$vehicleLat && $preLng==$vehicleLng)
					{
						continue;
					}

					$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
					$preLat=$vehicleLat;
					$preLng=$vehicleLng;


					$locationActivity[$i]['no'] = $i+1;
					$locationActivity[$i]['recordDate'] = $recordDate;
					$locationActivity[$i]['recordTime'] = $recordTime;
					$locationActivity[$i]['driver'] = $driver;
					$locationActivity[$i]['nearaddress'] = $nearaddress;
					$locationActivity[$i]['speed'] = $vehicleSpeed*1.8;


					$i++;
				}
			}
		}
		return $locationActivity;

	}
	private function _getMileageReportData($dbc, $deviceid, $dirver, $timeInterval, $startDate, $endDate){
		$query = "SELECT * FROM ".$this->db_tracker.".d".$deviceid." WHERE server_date BETWEEN '".$startDate."' AND '".$endDate."' order by event_number";
		//echo $query;
		$result = $this->_getResult($dbc,$query);
		//pr($results);
		$mileageData = array();
		if(count($result)>0){

			$preLat=0;
			$preLng=0;
			$recordTimeWithInterval=0;

			$startDate=date('Y-m-d', strtotime('+1 day', strtotime(date($startDate))));
			$i = 0;
			if($result){
				while ($row = $result->fetch_assoc())
				{
					$recordDate=$row['server_date'];
					$recordTime=$row['server_time'];
					if(strtotime($recordTime) > $recordTimeWithInterval)
					{
						$recordTimeWithInterval=strtotime($recordTime)+60*$timeInterval;
						$event_number=$row['event_number'];
						$vehicleSpeed=$row['speed'];
						$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');

						$recordDate=strftime("%a %d %b %Y", strtotime($recordDate));
						$vehicleLat=$row['latitude'];
						$vehicleLng=$row['longitude'];
						$vehicleStatus=$row['veh_status'];
						$ignitionStatus=substr($vehicleStatus,5,1);
						if($preLat==$vehicleLat && $preLng==$vehicleLng)
						{
							continue;
						}
						$mileage=$this->_distance($vehicleLat, $vehicleLng, $preLat, $preLng);
						$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
						$preLat=$vehicleLat;
						$preLng=$vehicleLng;


						$mileageData[$i]['no'] = $i+1;
						$mileageData[$i]['recordDate'] = $recordDate;
						$mileageData[$i]['recordTime'] = $recordTime;
						$mileageData[$i]['dirver'] = $dirver;
						$mileageData[$i]['nearaddress'] = $nearaddress;
						$mileageData[$i]['mileage'] = $mileage;

						$i++;
					}
				}
			}
		}
		return $mileageData;

	}

	private function _getSpeedReportData($dbc, $deviceList, $beginDate, $endDate, $speed)
	{
		$reportData = array();
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
				
			$daysDifference=$this->_daysDifference($endDate,$beginDate);

			foreach ($deviceList as $deviceid)
			{
				$server_date = $beginDate;
				$data = array();

				$rowDeviceInfo = $this->_getDeviceProfile($dbc, $deviceid);
				$registration_number=$rowDeviceInfo['name'];

				for($k = 0; $k < $daysDifference; $k++)
				{
					$queryMaxSpeed = '';
					switch($speed)
					{

						case '0':
							$queryMaxSpeed="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' ORDER BY CONVERT(speed,DECIMAL(8,2)) DESC LIMIT 1";
					  break;
						case '50':
					  $queryMaxSpeed="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' AND CONVERT(speed,DECIMAL(8,2))>(50/1.8) ORDER BY CONVERT(speed,DECIMAL(8,2)) DESC LIMIT 1";
					  break;
						case '60':
							$queryMaxSpeed="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' AND CONVERT(speed,DECIMAL(8,2))>(60/1.8) ORDER BY CONVERT(speed,DECIMAL(8,2)) DESC LIMIT 1";
					  break;
						case '70':
					  $queryMaxSpeed="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' AND CONVERT(speed,DECIMAL(8,2))>(70/1.8) ORDER BY CONVERT(speed,DECIMAL(8,2)) DESC LIMIT 1";
					  break;
						case '80':
							$queryMaxSpeed="SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' AND CONVERT(speed,DECIMAL(8,2))>(80/1.8) ORDER BY CONVERT(speed,DECIMAL(8,2)) DESC LIMIT 1";
					  break;
					}
						
					$queryAvgSpeed="SELECT AVG(CONVERT(speed,DECIMAL(8,2))) AS avgSpeed FROM tracker_devices.d".$deviceid." WHERE server_date = '".$server_date."' AND CONVERT(speed,DECIMAL(8,2))>0 ";
					$result = $this->_getResult($dbc, $queryAvgSpeed);
					if(!empty($result)){
						$row = $result->fetch_assoc();
						$avgSpeed=$row['avgSpeed'];
						$avgSpeed=number_format($avgSpeed, 2, '.', '');
					}
					else{
						$avgSpeed = '';
					}

					$maxSpeed = 0;
					$result = $this->_getResult($dbc, $queryMaxSpeed);
					if ($result) {
						$row = $result->fetch_assoc();
						$maxSpeed=$row['speed'];
						$vehicleLat=$row['latitude'];
						$vehicleLng=$row['longitude'];
						$nearaddress = '';
						if($maxSpeed>0){
							$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
						}
						if ($maxSpeed > 0 && $avgSpeed > 0) {
							$data[$k]['reg_number'] = $registration_number;
							$data[$k]['date'] = strftime("%a %d %b %Y", strtotime($server_date));
							$data[$k]['avg_speed'] = $avgSpeed*1.8;;
							$data[$k]['max_speed'] = $maxSpeed*1.8;
							$data[$k]['location'] = $nearaddress;
							$values[$k] = $data[$k];
						}
						$server_date=date('Y-m-d', strtotime('+1 day', strtotime(date($server_date))));
					}
					//Prepare Data to display
				}
				$reportData[$registration_number] = $values;
			}
		}
		return $reportData;
	}
	private function _getVehicleUsesReportData($dbc, $deviceid, $startDate, $endDate){
		$query = "SELECT * FROM ".$this->db_tracker.".d".$deviceid." WHERE server_date BETWEEN '".$startDate."' AND '".$endDate."' order by event_number";
		//echo $query;
		$result = $this->_getResult($dbc,$query);
		//pr($results);
		$vehicleUsesData = array();
		if(count($result)>0){

			$preLat=0;
			$preLng=0;
			$preIgnitionStatus=5;
			$preTime="00:00:00";
			$first_time_eng_on=false;
			$recordTimeWithInterval=0;

			$startDate=date('Y-m-d', strtotime('+1 day', strtotime(date($startDate))));
			$i = 0;
			//pr($result);
			while ($row = $result->fetch_assoc())
			{
				$recordDate=$row['server_date'];
				$recordTime=$row['server_time'];
				$event_number=$row['event_number'];
				$vehicleSpeed=$row['speed'];
				$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');

				$recordDate=strftime("%a %d %b %Y", strtotime($recordDate));
				$vehicleLat=$row['latitude'];
				$vehicleLng=$row['longitude'];
				$vehicleStatus=$row['veh_status'];
				$ignitionStatus=substr($vehicleStatus,5,1);
				if($first_time_eng_on==false)
				{
					if($ignitionStatus==1)
					{
						$first_time_eng_on=true;
						$preTime=$recordTime;
						$preLat=$vehicleLat;
						$preLng=$vehicleLng;
						$preIgnitionStatus=$ignitionStatus;

					}
					else
					{
						continue;
					}
				}
				else
				{
					if(($preLat==$vehicleLat && $preLng==$vehicleLng)||( $preIgnitionStatus==$ignitionStatus))
					{
						continue;
					}


					//$duration= getTimeDiff($preTime,$recordTime);
					$duration=$this->_timeDiff($recordDate." ".$preTime,$recordDate." ".$recordTime);

					$vehicleUsesData[$i]['no'] = $i+1;
					$vehicleUsesData[$i]['preTime'] = $preTime;
					$vehicleUsesData[$i]['recordTime'] = $recordTime;
					$vehicleUsesData[$i]['duration'] = $duration;

					$preLat=$vehicleLat;
					$preLng=$vehicleLng;
					$preIgnitionStatus=$ignitionStatus;
					$preTime=$recordTime;
					$first_time_eng_on=false;
					$i++;
				}
			}
		}
		return $vehicleUsesData;

	}
	private function _getEngineOnOffReportData($dbc, $deviceid, $startDate, $endDate){
		$query = "SELECT * FROM ".$this->db_tracker.".d".$deviceid." WHERE server_date BETWEEN '".$startDate."' AND '".$endDate."' order by event_number";
		//echo $query;
		$result = $this->_getResult($dbc,$query);
		//pr($results);
		$engineOnOffData = array();
		if(count($result)>0){

			$preLat=0;
			$preLng=0;

			$startDate=date('Y-m-d', strtotime('+1 day', strtotime(date($startDate))));
			$i = 0;
			//pr($result);
			while ($row = $result->fetch_assoc())
			{
				$recordDate=$row['server_date'];
				$recordTime=$row['server_time'];
				$event_number=$row['event_number'];
				$vehicleSpeed=$row['speed']*1.8;
				$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');

				$recordDate=strftime("%a %d %b %Y", strtotime($recordDate));
				$vehicleLat=$row['latitude'];
				$vehicleLng=$row['longitude'];
				$vehicleStatus=$row['veh_status'];
				$ignitionStatus=substr($vehicleStatus,5,1);
				if($vehicleSpeed>0) $ignitionStatus=1;
				if($ignitionStatus==1)
				{
					$ignitionStatus="Ignition On";
				}
				else
				{
					$ignitionStatus="Ignition Off";
				}
				if($preLat==$vehicleLat && $preLng==$vehicleLng)
				{
					continue;
				}
				$mileage=$this->_distance($vehicleLat, $vehicleLng, $preLat, $preLng);
				$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
				$preLat=$vehicleLat;
				$preLng=$vehicleLng;


				$engineOnOffData[$i]['no'] = $i+1;
				$engineOnOffData[$i]['recordDate'] = $recordDate;
				$engineOnOffData[$i]['recordTime'] = $recordTime;
				$engineOnOffData[$i]['dirver'] = $dirver;
				$engineOnOffData[$i]['ignitionStatus'] = $ignitionStatus;
				$engineOnOffData[$i]['nearaddress'] = $nearaddress;

				$i++;
			}
		}
		return $engineOnOffData;

	}

	private function _queryAddress($vehicleLat,$vehicleLng,$dbc)
	{

		$query ="SELECT *,(((ACOS(SIN((".$vehicleLat."*PI()/180)) *
		SIN((lat*PI()/180))+COS((".$vehicleLat."*PI()/180)) *
		COS((lat*PI()/180)) * COS(((".$vehicleLng."- lng)
		*PI()/180))))*180/PI())) AS distance FROM ".$this->db_geo."."."latlng  ORDER BY distance limit 1";

		$location = '';
		$results = $dbc->query($query);
		if($results){
			$row = $results->fetch_array(MYSQLI_ASSOC);
	
			//$result = mysql_query($query, $conn);
			//$row = mysql_fetch_assoc($result);
			$location=$row['address'];
			global $lat, $lng;
			$lat=$row['lat'];
			$lng=$row['lng'];
			$distance=$row['distance'];
			$distance = $distance*60*1.1515*1.609344;
			$distance=number_format($distance, 3, '.', '');
			$location=$distance.' km from '.$location;
			// $distance=round($distance,5);
			//return $location.' / '.$distance;
		}
		return $location;
		
	}

	private function _getTimeDiff($dtime,$atime)
	{
		$nextDay=$dtime>$atime?1:0;
		$dep=EXPLODE(':',$dtime);
		$arr=EXPLODE(':',$atime);
		$diff=ABS(MKTIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));

		$hours=FLOOR($diff/(60*60));
		$mins=FLOOR(($diff-($hours*60*60))/(60));
		$secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
		IF(STRLEN($hours)<2){
			$hours="0".$hours;
		}
		IF(STRLEN($mins)<2){
			$mins="0".$mins;
		}
		IF(STRLEN($secs)<2){
			$secs="0".$secs;
		}
		//return $diff;
		return $hours.':'.$mins.':'.$secs;
	}


	private function _daysDifference($endDate, $beginDate)
	{
		$date_parts1=explode("-", $beginDate);
		$date_parts2=explode("-", $endDate);
		$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
		return $end_date - $start_date;
	}

	private function _travelDistance($dbc, $query)
	{
		$dist = 0;
		$prelat = 0;
		$prelng = 0;
		$result = $this->_getResult($dbc,$query);
		if ($result) {
			while ($row = $result->fetch_assoc()){
				$lat = $row['latitude'];
				$lng = $row['longitude'];
				if ($prelat != 0 && $prelng != 0 ) {
					$dist += $this->_distance($prelat, $prelng, $lat, $lng);
				}
				$prelat = $lat;
				$prelng = $lng;
			}
		}
		return $dist; //in KM
	}


	private function _distance($lat1, $lng1, $lat2, $lng2)
	{

		$theta = $lng1 - $lng2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		if($miles<0 || $miles==NAN || $miles>100)$miles=0;
		$kilometers =$miles * 1.609344;
		$kilometers=number_format($kilometers, 3, '.', '');
		return ($kilometers);

	}

	private function _travelTime($dbc, $query)
	{
		$tTime = 0;
		$preDateTime = 0;
		$result = $this->_getResult($dbc,$query);
		if ($result) {
			while ($row = $result->fetch_assoc()){
				$recordDate=$row['server_date'];
				$recordTime=$row['server_time'];
				$recordDate=$recordDate.' '.$recordTime;

				if ($preDateTime != 0)
				{
					$firstTime=strtotime($recordDate);
					$lastTime=strtotime($preDateTime);
						
					// perform subtraction to get the difference (in seconds) between times
					$tTime += $firstTime - $lastTime;
				}
				$preDateTime = $recordDate;
			}
		}
		return $tTime; //in KM
	}

	private function _timeDiff($firstTime,$lastTime)
	{

		// convert to unix timestamps
		$firstTime=strtotime($firstTime);
		$lastTime=strtotime($lastTime);

		// perform subtraction to get the difference (in seconds) between times
		$diff=$lastTime-$firstTime;

		$hours=FLOOR($diff/(60*60));
		$mins=FLOOR(($diff-($hours*60*60))/(60));
		$secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
		IF(STRLEN($hours)<2){
			$hours="0".$hours;
		}
		IF(STRLEN($mins)<2){
			$mins="0".$mins;
		}
		IF(STRLEN($secs)<2){
			$secs="0".$secs;
		}
		return $hours.' hr '.$mins.' min '.$secs.' sec ';
	}

	private function _secToHMS($diff)
	{
		$hours=FLOOR($diff/(60*60));
		$mins=FLOOR(($diff-($hours*60*60))/(60));
		$secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
		IF(STRLEN($hours)<2){
			$hours="0".$hours;
		}
		IF(STRLEN($mins)<2){
			$mins="0".$mins;
		}
		IF(STRLEN($secs)<2){
			$secs="0".$secs;
		}
		return $hours.' hr '.$mins.' min '.$secs.' sec ';
	}
}
