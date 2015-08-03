<?php
App::uses('AppController', 'Controller');
/**
 * AccountTypes Controller
 *
 * @property AccountType $AccountType
 */
class TrackerTracksController extends AppController {

	var $uses = array('ClientDevice','ClientContactDevice', 'ClientInfo', 'ClientContact', 'User');

	public function callcenterHistory($deviceid, $deviceType){
		$this->layout = 'callcenter_history';
		$this->set('deviceId', $deviceid);
		$this->set('deviceType', $deviceType);
	}

	public function search($word=null){
		$word = $this->request->data['query'];
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			$query = "

			SELECT  CONCAT('User#',`id`) AS 'id', CONCAT(`username`,' <i>(User-Name)</i>') AS 'name' FROM users WHERE `username` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('User#',`id`) AS 'id', CONCAT(`email`,' <i>(User-Email)</i>') AS 'name' FROM users WHERE `email` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Device#',`id`) AS 'id', CONCAT(`deviceid`,' <i>(Deviceid)</i>') AS 'name' FROM client_devices WHERE `deviceid` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Device#',`id`) AS 'id', CONCAT(`mob_no`,' <i>(Unit-SIM)</i>') AS 'name' FROM client_devices WHERE `mob_no` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Device#',`id`) AS 'id', CONCAT(`name`,' <i>(Vehicle-Reg)</i>') AS 'name' FROM client_devices WHERE `name` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Device#',`id`) AS 'id', CONCAT(`tracker_id`,' <i>(Tracker ID)</i>') AS 'name' FROM client_devices WHERE `tracker_id` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Contact#',`id`) AS 'id', CONCAT(`name`,' <i>(Contact-Name)</i>') AS 'name' FROM client_contacts WHERE `name` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Contact#',`id`) AS 'id', CONCAT(`mobile`,' <i>(Contact-Mobile)</i>') AS 'name' FROM client_contacts WHERE `mobile` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Contact#',`id`) AS 'id', CONCAT(`phone`,' <i>(Contact-Phone)</i>') AS 'name' FROM client_contacts WHERE `phone` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT	CONCAT('Contact#',`id`) AS 'id', CONCAT(`email`,' <i>(Contact-Email)</i>') AS 'name' FROM client_contacts WHERE `email` LIKE '$word%' LIMIT 0, 10

			";
			$results = $dbc->query($query);

			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					//pr($row);
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}

	public function getUserByDeviceOrContact(){
		$inputData = $this->request->data;
		$inputDataArray = split('#', $inputData);

		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			$user_id = '';
			if($inputDataArray[0] == 'Device'){
				$query = "select ci.user_id as user from client_devices as cd join client_infos as ci on ci.id = cd.client_info_id where cd.id = $inputDataArray[1]";
				$results = $dbc->query($query);
				$row = $results->fetch_assoc();
				$user_id = $row['user'];
			}
			else if($inputDataArray[0] == 'Contact'){
				$query = "select cc.user_id as user from client_contacts as cc  where cc.id = '$inputDataArray[1]'";
				$results = $dbc->query($query);
				$row = $results->fetch_assoc();
				$user_id = $row['user'];
			}
			else{
				$user_id = $inputDataArray[1];
			}

			$userQuery = "Select username from users where id = '$user_id'";

			$results = $dbc->query($userQuery);
			$row = $results->fetch_assoc();

			$rows['id'] = $user_id;
			$rows['name'] = $row['username'];
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));

	}

	public function searchByTrackerID($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		//pr($this->request->data);
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			$query = "
			SELECT  CONCAT(`id`) AS 'id', CONCAT(`deviceid`) AS 'name', CONCAT(`name`,' <i>(Vehicle-Reg)</i>') AS 'rname' FROM client_devices WHERE `tracker_id` LIKE '$word%' LIMIT 0, 10
			";
			$results = $dbc->query($query);

			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					//pr($row);
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}
	
	

	public function searchByRegNumber($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			/*$query = "
			 SELECT CONCAT('Device#',`deviceid`) AS 'deviceid', 'tracker_id', CONCAT(`name`,' <i>(Vehicle-Reg)</i>') AS 'name' FROM client_devices WHERE `name` LIKE '$word%' LIMIT 0, 10
			";*/
			$query = "
			SELECT CONCAT('Device#',`deviceid`) AS 'deviceid', 'tracker_id', CONCAT(`name`) AS 'name' FROM client_devices WHERE `name` LIKE '$word%' LIMIT 0, 10
			";
			$results = $dbc->query($query);

			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					//pr($row);
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}

	public function searchByRegNumberWithoutLike($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			/*$query = "
			 SELECT CONCAT('Device#',`deviceid`) AS 'deviceid', 'tracker_id', CONCAT(`name`,' <i>(Vehicle-Reg)</i>') AS 'name' FROM client_devices WHERE `name` LIKE '$word%' LIMIT 0, 10
			";*/
			$query = "
			SELECT CONCAT('Device#',`deviceid`) AS 'deviceid', 'tracker_id', CONCAT(`name`) AS 'name' FROM client_devices WHERE `name`='$word' LIMIT 0, 10
			";
			$results = $dbc->query($query);

			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					//pr($row);
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}

	public function searchContactByName($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		//pr($this->request->data);
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			// 			$query = "
			// 			SELECT  `id` AS 'id', CONCAT(`name`) AS 'name' FROM client_infos WHERE `name` LIKE '$word%' LIMIT 0, 10
			// 			";
			$query = "
			select ci.id as 'id', ci.name as 'name', users.username as 'username' from client_infos as ci left join users on users.client_info_id = ci.id where users.username LIKE '$word%' and ci.client_type_id = 2 LIMIT 0, 10
			";
			$results = $dbc->query($query);

			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					//pr($row);
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}

	public function searchSingleClient($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			$query = "
			select ci.id as 'id', ci.name as 'name', users.username as 'username' from client_infos as ci left join users on users.client_info_id = ci.id where users.username LIKE '$word%' and ci.client_type_id = 1 LIMIT 0, 10
			";
			//SELECT id, name FROM client_infos WHERE name LIKE '$word%' and client_type_id = 1 LIMIT 0, 10
			$results = $dbc->query($query);
			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}

	public function searchGroupClient($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			$query = "select ci.id as 'id', ci.name as 'name', users.username as 'username' from client_infos as ci left join users on users.client_info_id = ci.id where users.username LIKE '$word%' and ci.client_type_id = 2 and users.user_type_id = 3 LIMIT 0, 10 ";
			$results = $dbc->query($query);
			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}

	public function searchDevices($word=null){
		$word = $this->request->data['query'];
		//pr($this->request->data);
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			$query = "
			SELECT  CONCAT('Device#',`id`) AS 'id', CONCAT(`deviceid`,' <i>(Deviceid)</i>') AS 'name' FROM client_devices WHERE `deviceid` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Device#',`id`) AS 'id', CONCAT(`name`,' <i>(Unit-SIM)</i>') AS 'name' FROM client_devices WHERE `mob_no` LIKE '$word%' LIMIT 0, 10
			UNION
			SELECT  CONCAT('Device#',`id`) AS 'id', CONCAT(`name`,' <i>(Vehicle-Reg)</i>') AS 'name' FROM client_devices WHERE `name` LIKE '$word%' LIMIT 0, 10


			";
			//			SELECT  CONCAT(`odj`,'#',`ref_id`) 'id',   CONCAT(`search`,' <i>(',`odj`,'-',`fld`,')</i>') 'name' FROM `search_cache` WHERE `obj`='Device' AND `search` LIKE '$word%' LIMIT 0, 100

			$results = $dbc->query($query);

			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					//pr($row);
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}
	public function tracker_live_view($did = null){
		if($did==null){
			if($this->getUserRole()=="single"){
				$clientid = $this->getUserClientid();
				$deviceInfo = $this->ClientDevice->find('first',array(
						'recursive' => -1,
						'fields' => array(
								'ClientDevice.deviceid'
						),
						'conditions' => array('ClientDevice.client_info_id' => $clientid)
				));
				$did = $deviceInfo['ClientDevice']['deviceid'];

			}else{
				return new CakeResponse(array('body' => ''));
			}
		}
		$this->set('did',$did);
	}
	
	public function report_live_view(){
		$regNumber = $this->request->query['reg'];
		$selectedDate = $this->request->query['rdate'];
		if($regNumber!=null && $selectedDate!=null){
			$deviceInfo = $this->ClientDevice->find('first',array(
					'recursive' => -1,
					'fields' => array(
							'ClientDevice.deviceid'
					),
					'conditions' => array('ClientDevice.name' => $regNumber)
			));
			$did = $deviceInfo['ClientDevice']['deviceid'];
			$this->set('did',$did);
			$this->set('sDate',$selectedDate);
		}
	}

	public function index(){
		$user = $this->Auth->user();
		$role = $user['UserType']['name'];
		$this->autoRender = false;
		$this->set('role',$role);
		$this->render('/TrackerTracks/'.$role);
	}

	public function singletracker($did=null){
		if($did){
			$conditions = array('ClientDevice.id'=>$did);
		}else{
			$user = $this->Auth->user();
			$clientid = $user['ClientInfo']['id'];
			$conditions = array('ClientDevice.client_info_id' => $clientid);
		}
		$role = $this->getUserRole();
		$deviceInfo = array();
		$deviceInfo = $this->ClientDevice->find('first',array(
				'recursive' => 2,
				'fields' => array(
						'ClientDevice.id',
						'ClientDevice.deviceid',
						'ClientDevice.device_type_id',
						'DeviceType.name',
						'ClientDevice.device_info_id',
						'DeviceInfo.name',
						'ClientDevice.imei',
						'ClientDevice.mob_no',
						'ClientDevice.name',
						'ClientDevice.speed_limit',
						// 											'ClientDevice.expiry_date',
						'ClientDevice.vehicle_type_id',
						'VehicleType.name'
				),
				'conditions' => $conditions,
				'order' => array('ClientDevice.deviceid')
		));

		$deviceInfo['DeviceStatus'] = $this->_get_device_current_info($deviceInfo['ClientDevice']['deviceid']);
		$this->set(compact('deviceInfo','role'));
	}

	public function livetracker($did=null){
		$user = $this->Auth->user();
		$clientid = $user['ClientInfo']['id'];

		$role = $this->Auth->user('role');
		//echo $did;
		$deviceInfo = array();
		$deviceInfo = $this->ClientDevice->find('first',

				array(
						'recursive' => 2,
						'fields' => array(
								'ClientDevice.id',
								'ClientDevice.deviceid',
								'ClientDevice.device_type_id',
								'DeviceType.name',
								'ClientDevice.device_info_id',
								'DeviceInfo.name',
								'ClientDevice.imei',
								'ClientDevice.mob_no',
								'ClientDevice.name',
								//'ClientDevice.registration_number',
								'ClientDevice.speed_limit',
								'ClientDevice.expiry_date',
								'ClientDevice.vehicle_type_id',
								'VehicleType.name'
						),
						'conditions' => array(
								'AND' => array(
										array('ClientDevice.client_info_id' => $clientid),
										array('ClientDevice.deviceid' => $did)
								)



						),
						'order' => array('ClientDevice.deviceid')
				));
		if($role=="group"){
			$deviceInfo['DeviceProfiles'] = $this->ClientDevice->find('all',

					array(
							'recursive' => 2,
							'fields' => array(
									'ClientDevice.id',
									'ClientDevice.deviceid',
									'ClientDevice.device_type_id',
									'DeviceType.name',
									'ClientDevice.device_info_id',
									'DeviceInfo.name',
									'ClientDevice.imei',
									'ClientDevice.mob_no',
									'ClientDevice.name',
									//'ClientDevice.registration_number',
									'ClientDevice.speed_limit',
									'ClientDevice.expiry_date',
									'ClientDevice.vehicle_type_id',
									'VehicleType.name'
							),
							'conditions' => array(
									array('ClientDevice.client_info_id' => $clientid)

							),
							'order' => array('ClientDevice.deviceid')
					));
		}
		$deviceInfo['DeviceStatus'] = $this->_get_device_current_info($did);
		$this->set(compact('deviceInfo','role'));
		//pr($deviceInfo);
		//return;
		//return $deviceInfo;
	}




	public function trackers_summary(){

	}

	public function device_profile()
	{
		$this->render('/CallCenter/device_profile');
	}

	public function trackers_summary_updates(){
		//pr($this->request);
		if(isset($this->request->data['deviceids']) && ($this->request->data['deviceids']!="")){
			$deviceids = $this->request->data['deviceids'];
		}else{
			// fetch deviceids

		}
		$result = $this->_get_trackers_summary_updates($deviceids);
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($result)));
	}

	private function _get_trackers_summary_updates($deviceids){

		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		$device_updates = array();

		if($DB->default['datasource'] === 'Database/Mysql')
		{
			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);
			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
			$sql = "SELECT * FROM tracker_devices.devicetracks1 WHERE deviceid in (".$deviceids.")";
			//echo $sql;
			$query = $dbc->query($sql);
			if (!$query) {
				die('Invalid query: ' . mysql_error());
			}
			while($result = $query->fetch_array())
			{
				if($result && $result['event_number']){

					$vehicleLat=$result['latitude'];
					$vehicleLng=$result['longitude'];
					$vehicleStatus=$result['veh_status'];
					$ignitionStatus=substr($vehicleStatus,5,1);

					$vehicleSpeed=$result['speed'];
					$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');
					$vehicleSpeed=$vehicleSpeed*1.8;
					if($vehicleSpeed>0) $ignitionStatus=1;

					$recordDate=$result['server_date'];
					$recordTime=$result['server_time'];

					$lastRecordTime = time();
					$serverRecordDateTime=strtotime($recordDate ." ". $recordTime );

					$timeDiff = $lastRecordTime-$serverRecordDateTime;

					$vehicleAltitude=$result['altitude'];
					$vehicleOdometer=$result['odometer'];

					$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
					$serverDateTime=($recordDate ." ". $recordTime );

					$rows = array();
					$rows['deviceid'] = $result['deviceid'];
					$rows['recordEventNumber'] = $result['event_number'];

					$rows['timeDiff'] = $timeDiff;
					$rows['serverDateTime'] = $serverDateTime;
					$rows['recordDate'] = $recordDate;
					$rows['recordTime'] = $recordTime;
					$rows['vehicleLat'] = $vehicleLat;
					$rows['vehicleLng'] = $vehicleLng;
					$rows['nearaddress'] = $nearaddress;
					$rows['vehicleAltitude'] = $vehicleAltitude;
					$rows['vehicleSpeed'] = $vehicleSpeed;
					$rows['ignitionStatus'] = $ignitionStatus;
					$rows['vehicleOdometer'] = $vehicleOdometer;

					$rows['vehicleFuel'] = $result['fuel'];

					$device_updates[] = $rows;
				}else{
					$device_updates[] = $this->_defaultDeviceCurInfo($result['deviceid']);
				}
			}
			$dbc->close();
		} else {
			die("Please use mysqli");
		}
		return $device_updates;
	}

	public function livetrackerjson($did=null){
		$user = $this->Auth->user();
		$clientid = $user['ClientInfo']['id'];
		$role = $this->Auth->user('role');

		$deviceInfo['DeviceStatus']['DeviceStatus'] = $this->_get_device_current_info($did);
		return new CakeResponse(array('type' => 'application/json','body' => json_encode($deviceInfo['DeviceStatus'])));
	}
	
	public function reporttrackerjson($did=null, $currentDate=null){	
		$deviceInfo['DeviceStatus']['DeviceStatus'] = $this->_get_device_current_info($did);
		return new CakeResponse(array('type' => 'application/json','body' => json_encode($deviceInfo['DeviceStatus'])));
	}

	public function get_all_devices_profile(){
		$deviceInfo['DeviceProfiles'] = $this->get_device_profiles("all");
		$deviceInfo['DeviceStatus'] = $this->_get_all_devices_current_info($deviceInfo['DeviceProfiles']);
		return $deviceInfo;

	}
	public function get_all_devices_profile_json($clientid = null){
		$deviceInfo['DeviceProfiles'] = $this->get_device_profiles("all",$clientid);
		$deviceInfo['DeviceStatus'] = $this->_get_all_devices_current_info($deviceInfo['DeviceProfiles']);

		return new CakeResponse(array('type' => 'application/json','body' => json_encode($deviceInfo)));
	}

	public function get_selected_device_profile_json($deviceid){
		$deviceInfo['DeviceProfiles'] = $this->get_selected_device_profile($deviceid);
		return new CakeResponse(array('type' => 'application/json','body' => json_encode($deviceInfo)));
	}

	public function get_all_devices_status_json($did="all"){
		$deviceProfiles = $this->get_device_profiles($did);

		$deviceStatus = $this->_get_all_devices_current_info($deviceProfiles);

		return new CakeResponse(array('type' => 'application/json','body' => json_encode($deviceStatus)));
	}

	public function get_device_profiles($id="all", $clientid = null){
		$sDeviceProfile = array();
		$role = $this->getUserRole();
		if($role == 'admin'){
			$deviceInfo['DeviceProfiles'] = $this->ClientDevice->find('all',
					array(
							'recursive' => 0,
							'fields' => array(
									'ClientDevice.id',
									'ClientDevice.deviceid',
									'ClientDevice.device_type_id',
									'DeviceType.name',
									'ClientDevice.device_info_id',
									'DeviceInfo.name',
									'ClientDevice.imei',
									'ClientDevice.mob_no',
									'ClientDevice.name',
									'ClientDevice.tags',
									'ClientDevice.speed_limit',
									'ClientDeviceSubscription.expire_date',
									'ClientDevice.vehicle_type_id',
									'VehicleType.name'
							),
							'conditions' => array(
									array('ClientDevice.client_info_id' => $clientid)
							),
							'order' => array('ClientDevice.deviceid')
					));
			$sDeviceProfile = $deviceInfo['DeviceProfiles'];
		}
		else{
			if($this->Session->check('sDeviceProfile')){

				$deviceInfo['DeviceProfiles'] = $this->Session->read('sDeviceProfile');
			}else{
				if($role=="group"){
					$contactid = $this->getUserContactid();
					$divids = $this->ClientContactDevice->find('list',array('recursive' => -1,'fields' => array('ClientContactDevice.client_device_id'),
							'conditions' => array('ClientContactDevice.client_contact_id' => $contactid)));
					$deviceInfo['DeviceProfiles'] = $this->ClientDevice->find('all',
							array(
									'recursive' => 0,
									'fields' => array(
											'ClientDevice.id',
											'ClientDevice.deviceid',
											'ClientDevice.device_type_id',
											'DeviceType.name',
											'ClientDevice.device_info_id',
											'DeviceInfo.name',
											'ClientDevice.imei',
											'ClientDevice.mob_no',
											'ClientDevice.name',
											'ClientDevice.tags',
											'ClientDevice.speed_limit',
											'ClientDeviceSubscription.expire_date',
											'ClientDevice.vehicle_type_id',
											'VehicleType.name'
									),
									'conditions' => array(
											array('ClientDevice.id' => $divids)
									),
									'order' => array('ClientDevice.deviceid')
							));
					$sDeviceProfile = $deviceInfo['DeviceProfiles'];
				}
				else{
					$clientid = $this->getUserClientid();
					$deviceInfo['DeviceProfiles'] = $this->ClientDevice->find('all',
							array(
									'recursive' => 0,
									'fields' => array(
											'ClientDevice.id',
											'ClientDevice.deviceid',
											'ClientDevice.device_type_id',
											'DeviceType.name',
											'ClientDevice.device_info_id',
											'DeviceInfo.name',
											'ClientDevice.imei',
											'ClientDevice.mob_no',
											'ClientDevice.name',
											'ClientDevice.tags',
											'ClientDevice.speed_limit',
											'ClientDeviceSubscription.expire_date',
											'ClientDevice.vehicle_type_id',
											'VehicleType.name'
									),
									'conditions' => array(
											array('ClientDevice.client_info_id' => $clientid)
									),
									'order' => array('ClientDevice.deviceid')
							));
					$sDeviceProfile = $deviceInfo['DeviceProfiles'];
				}
			}
		}
		if($id=="all"){
			return $sDeviceProfile;
		}else{
			for($i=0;$i< sizeof($sDeviceProfile);$i++){
				if($sDeviceProfile[$i]['ClientDevice']['id']==$id)
					return $sDeviceProfile[$i];
			}
		}
	}

	public function get_selected_device_profile($deviceid){
		$sDeviceProfile = array();

		$deviceInfo['DeviceProfiles'] = $this->ClientDevice->find('all',
				array(
						'recursive' => 0,
						'fields' => array(
								'ClientDevice.id',
								'ClientDevice.deviceid',
								'ClientDevice.device_type_id',
								'DeviceType.name',
								'ClientDevice.device_info_id',
								'DeviceInfo.name',
								'ClientDevice.imei',
								'ClientDevice.mob_no',
								'ClientDevice.name',
								'ClientDevice.tags',
								//'ClientDevice.registration_number',
								'ClientDevice.speed_limit',
								'ClientDeviceSubscription.subscribe_date',
								'ClientDeviceSubscription.expire_date',
								'ClientDevice.vehicle_type_id',
								'ClientDevice.client_info_id',
								'VehicleType.name'
						),
						'conditions' => array(
								array('ClientDevice.deviceid' => $deviceid)
						),
						'order' => array('ClientDevice.deviceid')
				));

		$client_id = $deviceInfo['DeviceProfiles'][0]['ClientDevice']['client_info_id'];
		$deviceInfo['ClientProfile'] = $this->ClientInfo->find('all',
				array(
						'recursive' => 0,
						'fields' => array(
								'ClientInfo.id',
								'ClientInfo.name',
								'ClientInfo.address',
								'ClientInfo.buyerno',
								'ClientContact.name',
								'ClientContact.email',
								'ClientContact.mobile',
								'ClientContact.phone',
								'ClientContact.fax',
								'ClientType.name',
								'User.email',
								'ClientContact.mobile_home',
								'ClientContact.mobile_office',
								'CompanyType.name',

						),
						'conditions' => array(
								array('ClientInfo.id' => $client_id)
						),
						'order' => array('ClientInfo.id')
				));
		return	$deviceInfo; //$sDeviceProfile = $deviceInfo['DeviceProfiles'];
	}

	private function _get_device_current_info($deviceid){
		// need to check if the value is suuplied
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		$rdevices = array();
		if($DB->default['datasource'] === 'Database/Mysql') {
			// Connect using MySQLi
			//print "Connecting to database: ";
			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			// Make sure we use UTF8 encoding
			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}

			//$results = $dbc->query("SELECT * FROM tracker_devices.d".$deviceid."  order by event_number desc limit 1");
			$results = $dbc->query("SELECT * FROM tracker_devices.devicetracks1 WHERE deviceid = \"".$deviceid."\" limit 1");

			$results = $results->fetch_array();
			if($results && $results['event_number']){
				$vehicleLat=$results['latitude'];
				$vehicleLng=$results['longitude'];
				$vehicleStatus=$results['veh_status'];
				$ignitionStatus=substr($vehicleStatus,5,1);

				//
				$vehicleSpeed=$results['speed'];
				$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');
				$vehicleSpeed=$vehicleSpeed*1.8;
				if($vehicleSpeed>0) $ignitionStatus=1;

				$recordEventNumber=$results['event_number'];
				$recordDate=$results['server_date'];
				$recordTime=$results['server_time'];

				$lastRecordTime = time();
				$serverRecordDateTime=strtotime($recordDate ." ". $recordTime );

				$timeDiff  =$lastRecordTime-$serverRecordDateTime;


				$vehicleAltitude=$results['altitude'];
				$vehicleOdometer=$results['odometer'];

				$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
				$serverDateTime=($recordDate ." ". $recordTime );
				$rows = array();
				$rows['deviceid'] = $deviceid;
				$rows['timeDiff'] = $timeDiff;
				$rows['recordEventNumber'] = $recordEventNumber;
				$rows['serverDateTime'] = $serverDateTime;
				$rows['recordDate'] = $recordDate;
				$rows['recordTime'] = $recordTime;
				$rows['vehicleLat'] = $vehicleLat;
				$rows['vehicleLng'] = $vehicleLng;
				$rows['nearaddress'] = $nearaddress;
				$rows['vehicleAltitude'] = $vehicleAltitude;
				$rows['vehicleSpeed'] = $vehicleSpeed;
				$rows['ignitionStatus'] = $ignitionStatus;
				$rows['vehicleOdometer'] = $vehicleOdometer;
				$rows['vehicleFuel'] = $results['fuel'];

				$rdevices = $rows;
			}
			else
			{
				// Close the database connection
				$dbc->close();
				return $this->_defaultDeviceCurInfo($deviceid);
			}
			//get the last alert

			// Close the database connection
			$dbc->close();
			//return new CakeResponse(array('body' => json_encode($results->fetch_array())));
		} else {
			die("Please use mysqli");
		}
		pr($rdevices);
		return $rdevices;
	}



	private function _defaultDeviceCurInfo($deviceid){
		$rows = array();
		$rows['deviceid'] = $deviceid;
		$rows['timeDiff'] = 0;
		$rows['recordEventNumber'] = 0;
		$rows['serverDateTime'] = '';
		$rows['recordDate'] = '';
		$rows['recordTime'] = '';
		$rows['vehicleLat'] = '0.0';
		$rows['vehicleLng'] = '0.0';
		$rows['nearaddress'] = '';
		$rows['vehicleAltitude'] = 0;
		$rows['vehicleSpeed'] = 0;
		$rows['ignitionStatus'] = 0;
		$rows['vehicleOdometer'] = 0;
		$rows['vehicleFuel'] = 0;
		return $rows;	 //,
	}

	private function _get_all_devices_current_info($devices){
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();

		if($DB->default['datasource'] === 'Database/Mysql') {
			// Connect using MySQLi
			//print "Connecting to database: ";
			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			// Make sure we use UTF8 encoding
			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
			$rdevices = array();
			foreach($devices as &$device){
				$deviceid = $device['ClientDevice']['deviceid'];
				//echo "SELECT * FROM `tracker_devices`.`d".$deviceid."` LIMIT 0, 1;";
				// At this point you can just run raw queries like:
				// $results = $dbc->query("SELECT * FROM tracker_devices.d".$deviceid."  order by event_number desc limit 1");
				$results = $dbc->query("SELECT * FROM tracker_devices.devicetracks1 WHERE deviceid = \"".$deviceid."\" limit 1");
				$results = $results->fetch_array();
				if($results && $results['event_number']){
					$vehicleLat=$results['latitude'];
					$vehicleLng=$results['longitude'];
					$vehicleStatus=$results['veh_status'];
					$ignitionStatus=substr($vehicleStatus,5,1);


					$vehicleSpeed=$results['speed'];
					$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');
					$vehicleSpeed=$vehicleSpeed*1.8;
					if($vehicleSpeed>0) $ignitionStatus=1;

					$recordEventNumber=$results['event_number'];
					$recordDate=$results['server_date'];
					$recordTime=$results['server_time'];

					$lastRecordTime = time();
					$serverRecordDateTime=strtotime($recordDate ." ". $recordTime );

					$timeDiff  =$lastRecordTime-$serverRecordDateTime;


					$vehicleAltitude=$results['altitude'];
					$vehicleOdometer=$results['odometer'];

					$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
					$serverDateTime=($recordDate ." ". $recordTime );
					$rows = array();
					$rows['deviceid'] = $deviceid;
					$rows['timeDiff'] = $timeDiff;
					$rows['recordEventNumber'] = $recordEventNumber;
					$rows['serverDateTime'] = $serverDateTime;
					$rows['recordDate'] = $recordDate;
					$rows['recordTime'] = $recordTime;
					$rows['vehicleLat'] = $vehicleLat;
					$rows['vehicleLng'] = $vehicleLng;
					$rows['nearaddress'] = $nearaddress;
					$rows['vehicleAltitude'] = $vehicleAltitude;
					$rows['vehicleSpeed'] = $vehicleSpeed;
					$rows['ignitionStatus'] = $ignitionStatus;
					$rows['vehicleOdometer'] = $vehicleOdometer;
					$rows['vehicleFuel'] = $results['fuel'];

					//$result = array(''.$deviceid => $rows);
					//pr($result);
					//$rdevices[] = $result;
					$rdevices[''.$deviceid] = $rows;
				}else{
					$rdevices[''.$deviceid] = $this->_defaultDeviceCurInfo($deviceid);
				}
			}

			// Close the database connection
			$dbc->close();
			//return new CakeResponse(array('body' => json_encode($results->fetch_array())));
		} else {
			die("Please use mysqli");
		}
		return $rdevices;
	}

	private function _queryAddress($vehicleLat,$vehicleLng,$dbc)
	{

		$query ="SELECT *,(((ACOS(SIN((".$vehicleLat."*PI()/180)) *
		SIN((lat*PI()/180))+COS((".$vehicleLat."*PI()/180)) *
		COS((lat*PI()/180)) * COS(((".$vehicleLng."- lng)
		*PI()/180))))*180/PI())) AS distance FROM tracker_geoinfo.latlng  ORDER BY distance limit 1";

		$results = $dbc->query($query);
		$location = '';
		if($results)
		{
			$row = $results->fetch_array();
	
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

	public function getAccountProfile(){
		$sql = "Select count(*) as tt from client_devices where active=1;";
		$result = $this->ClientDevice->query($sql);
		$data['tt'] = $result[0][0]['tt'];

		$sql = "Select count(*) as tt from client_devices where active=1 and device_type_id = 2;";
		$result = $this->ClientDevice->query($sql);
		$data['vt'] = $result[0][0]['tt'];

		$sql = "Select count(*) as tt from client_devices where active=1 and device_type_id = 1;";
		$result = $this->ClientDevice->query($sql);
		$data['pt'] = $result[0][0]['tt'];

		$sql = "Select count(*) as tc from client_infos where 1;";
		$result = $this->ClientInfo->query($sql);
		$data['tc'] = $result[0][0]['tc'];

		$sql = "Select count(*) as tc from client_infos where client_type_id = 1;";
		$result = $this->ClientInfo->query($sql);
		$data['sc'] = $result[0][0]['tc'];

		$sql = "Select count(*) as tc from client_infos where client_type_id = 2;";
		$result = $this->ClientInfo->query($sql);
		$data['gc'] = $result[0][0]['tc'];

		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($data)));

	}

	public function getExpiredDevices(){
		$this->redirect(array('controller'=>'clientDevices', 'action'=>'acc_index/7'));
	}

	public function getResponseDataFromDevice(){
		$this->redirect(array('controller'=>'clientDevices', 'action'=>'res_index/8'));
	}

	public function get_non_responsive_devices(){

		$days = $this->request->query['days'];
		$d = $this->request->query['sDate'];
		$dt = strtotime("-".$days." days", strtotime($d));
		$date = date("Y-m-d", $dt);
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		$output = array();
		$rows = array();
		$results = array();


		if($DB->default['datasource'] === 'Database/Mysql') {

			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);

			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}

			$results = $dbc->query("SELECT deviceid as id, server_date, latitude, longitude  FROM tracker_devices.devicetracks1 WHERE server_date <= \"".$date."\" ");

			$sQuery = " SELECT FOUND_ROWS() ";

			$iTotal = $dbc->query($sQuery);
			$iTotal = $iTotal->fetch_assoc();

			while($r = $results->fetch_assoc())
			{
				$rows[] = $r;
			}

			$output = array(
					"sEcho" => 1,
					"iTotalRecords" =>  $iTotal['FOUND_ROWS()'],
					"iTotalDisplayRecords" =>  $iTotal['FOUND_ROWS()'],
					"aaData" => array()
			);

			$fields = array('id, server_date,latitude,longitude');


			for($j=0;$j<count($rows);$j++) {
				{
					$row = array();
					$clientData = $this->getClientInfoFromDevice($rows[$j]['id']); //deviceid
					$row[] = $clientData['devicename']; //devicename
					$row[] = $rows[$j]['id'];
					$row[] = $clientData['tracker_id'];
					$row[] = $clientData['sim']; //devicename
					$row[] = $rows[$j]['server_date'];//server date
					$nearaddress=$this->_queryAddress($rows[$j]['latitude'], $rows[$j]['longitude'], $dbc);//last address
					$row[] = $nearaddress;
					$row[] = $clientData['contactname']; //devicename
					$row[] = $clientData['mobile']; //devicename

					$row[] = "";
					$output['aaData'][] = $row;
				}
			}

			$dbc->close();
		} else {
			die("Please use mysqli");
		}
		return new CakeResponse(array('body' => json_encode($output)));
	}

	function getClientInfoFromDevice($deviceid)
	{
		$sql = "SELECT id, client_info_id, mob_no, name, tracker_id from client_devices where active = 1 and deviceid = $deviceid;";
		$deviceInfo = $this->ClientDevice->query($sql);

		$clientInfoId = $deviceInfo[0]['client_devices']['client_info_id'];
		$name = $deviceInfo[0]['client_devices']['name'];
		$sim = $deviceInfo[0]['client_devices']['mob_no'];
		$id = $deviceInfo[0]['client_devices']['id'];
		$tracker_id = $deviceInfo[0]['client_devices']['tracker_id'];


		$sql = "SELECT client_type_id from client_infos where id = '$clientInfoId'";
		$clientInfo = $this->ClientInfo->query($sql);
		$type = $clientInfo[0]['client_infos']['client_type_id'];
		if($type == 2){
			$sql = "SELECT client_contact_id from client_contact_devices where active = 1 and client_device_id = $id;";
			$contactInfo = $this->ClientContactDevice->query($sql);
			if(!empty($contactInfo)){
				$cId = $contactInfo[0]['client_contact_devices']['client_contact_id'];

				$sql = "SELECT name, mobile, email from client_contacts where id = '$cId';";
				$contactDetail = $this->ClientContactDevice->query($sql);

				$clientData = array();

				if (!empty($contactDetail))
				{
					$contactDetail = $contactDetail[0]['client_contacts'];
					$clientData['contactname'] = $contactDetail['name'];
					$clientData['mobile'] = $contactDetail['mobile'];
				}
			}
		}
		else{
			$sql = "SELECT name, mobile, email from client_contacts where client_info_id = '$clientInfoId';";
			$contactDetail = $this->ClientContact->query($sql);

			$clientData = array();

			if (!empty($contactDetail))
			{
				$contactDetail = $contactDetail[0]['client_contacts'];
				$clientData['contactname'] = $contactDetail['name'];
				$clientData['mobile'] = $contactDetail['mobile'];
			}
		}

		$clientData['devicename'] = $name;
		$clientData['sim'] = $sim;
		$clientData['tracker_id'] = $tracker_id;

		return $clientData;
	}

	function transfergroup(){

	}
	
	function getDateTimeWiseUpdate(){
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$deviceid = $this->request->query['deviceid'];
		$devicetime = $this->request->query['devicetime'];
		$splitDate = explode(" ", $devicetime);
		$sDate = $splitDate[0];
		$sTime = $splitDate[1];
		
		$DB = new DATABASE_CONFIG();
		$rdevices = array();
		if($DB->default['datasource'] === 'Database/Mysql') {
		
			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default['database']);
		
			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
			$query =  "SELECT * FROM tracker_devices.d".$deviceid." WHERE server_date = '".$sDate."' and server_time = '".$sTime."' limit 1";
			$results = $dbc->query($query);
			
			$results = $results->fetch_array();
			if($results && $results['event_number']){
				$vehicleLat=$results['latitude'];
				$vehicleLng=$results['longitude'];
				$vehicleStatus=$results['veh_status'];
				$ignitionStatus=substr($vehicleStatus,5,1);
			
				$vehicleSpeed=$results['speed'];
				$vehicleSpeed=number_format($vehicleSpeed, 2, '.', '');
				$vehicleSpeed=$vehicleSpeed*1.8;
				if($vehicleSpeed>0) $ignitionStatus=1;
			
				$recordEventNumber=$results['event_number'];
				$recordDate=$results['server_date'];
				$recordTime=$results['server_time'];
			
				$lastRecordTime = time();
				$serverRecordDateTime=strtotime($recordDate ." ". $recordTime );
			
				$timeDiff  =$lastRecordTime-$serverRecordDateTime;
			
			
				$vehicleAltitude=$results['altitude'];
				$vehicleOdometer=$results['odometer'];
			
				$nearaddress=$this->_queryAddress($vehicleLat,$vehicleLng,$dbc);
				$serverDateTime=($recordDate ." ". $recordTime );
				$rows = array();
				$rows['deviceid'] = $deviceid;
				$rows['timeDiff'] = $timeDiff;
				$rows['recordEventNumber'] = $recordEventNumber;
				$rows['serverDateTime'] = $serverDateTime;
				$rows['recordDate'] = $recordDate;
				$rows['recordTime'] = $recordTime;
				$rows['vehicleLat'] = $vehicleLat;
				$rows['vehicleLng'] = $vehicleLng;
				$rows['nearaddress'] = $nearaddress;
				$rows['vehicleAltitude'] = $vehicleAltitude;
				$rows['vehicleSpeed'] = $vehicleSpeed;
				$rows['ignitionStatus'] = $ignitionStatus;
				$rows['vehicleOdometer'] = $vehicleOdometer;
				$rows['vehicleFuel'] = $results['fuel'];

				$rdevices = $rows;
			}
			$dbc->close();
		}
		else {
			die("Please use mysqli");
		}
		
		$deviceInfo['DeviceStatus']['DeviceStatus'] = $rdevices;
		return new CakeResponse(array('type' => 'application/json','body' => json_encode($deviceInfo['DeviceStatus'])));
	}
	
	public function getAllUserID(){
		$dbc = $this->_getConnection ( 'database' );
		$rows = array ();
		if ($dbc != null) {
		$query = "select ci.id as 'id', ci.name as 'name', users.username as 'username', cd.deviceid as 'did'
				  from client_infos as ci
					left join users on users.client_info_id = ci.id
						left join client_devices as cd on cd.client_info_id = ci.id
					where ci.client_type_id = 1 and cd.deviceid IS NULL";
		$results = $dbc->query ( $query );
		if (count ( $results ) > 0) {
				while ( $row = $results->fetch_assoc () ) 
				{
					$rows [] = $row['username'];
				}
			}
		}			
		
		$this->set('userNames', $rows);
	}
			
	public function searchSingleClientWithoutDevice($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		$dbc = $this->_getConnection ( 'database' );
		$rows = array ();
		if ($dbc != null) {
			$query = "
			select ci.id as client_info_id, ci.name as client_name, users.id as user_id, users.username as username, cd.deviceid as did   
					from client_infos as ci 
						left join users on users.client_info_id = ci.id
							left join client_devices as cd on cd.client_info_id = ci.id 
					where users.username='$word' and ci.client_type_id = 1 and cd.deviceid IS NULL";

			$results = $dbc->query ( $query );
			if (count ( $results ) > 0) {
				while ( $row = $results->fetch_assoc () ) {
					$rows [] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}
	
	public function getDeviceInfoByTrackerId($word=null){
		if($word == null){
			$word = $this->request->data['query'];
		}
		//pr($this->request->data);
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null)
		{
			$query = "
				SELECT ci.id as client_info_id, users.id as user_id, cd.id as client_device_id, cd.deviceid, cd.mob_no, cd.name as vehicle_reg_no, users.username 
				FROM client_devices as cd 
					LEFT JOIN client_infos as ci on ci.id = cd.client_info_id
					LEFT JOIN users on users.client_info_id = ci.id 
				WHERE `tracker_id` LIKE '$word%' LIMIT 0, 10
			";
			
						
			$results = $dbc->query($query);
	
			if(count($results)>0){
			while ($row = $results->fetch_assoc())
			{
			//pr($row);
				$rows[] = $row;
			}
			}
			}
			return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}
	
}
