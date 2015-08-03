<?php
App::uses ( 'AppController', 'Controller' );
/**
 * ClientDevices Controller
 *
 * @property ClientDevice $ClientDevice
 *
 */
class ClientDevicesController extends AppController {
	var $uses = array (
			'ClientDevice',
			'ClientContactDevice',
			'AccountType',
			'User',
			'ClientDeviceSubscription',
			'TransferHistory' 
	);
	public function getDeviceInfo($id = null) {
		$devices = $this->ClientDevice->find ( 'all', array (
				'fields' => array (
						'ClientDevice.id',
						'ClientDevice.name',
						'VehicleType.name',
						'ClientDevice.active',
						'DeviceType.name',
						'ClientDevice.deviceid' 
				),
				'conditions' => array (
						'ClientDevice.id' => $id 
				) 
		) );
		
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $devices ) 
		) );
	}
	public function getDeviceIdByTrackerId($trackerId) {
		$sql = "SELECT id from client_devices where tracker_id = '$trackerId'";
		$clientdevice = $this->ClientDevice->query ( $sql );
		$deviceid = $clientdevice [0] ['client_devices'] ['id'];
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $deviceid ) 
		) );
	}
	public function getDeviceInfoForExtansion($id = null) {
		$devices = $this->ClientDevice->find ( 'all', array (
				'fields' => array (
						'ClientDevice.name',
						'VehicleType.name',
						'DeviceType.name',
						'ClientDevice.deviceid',
						'ClientDevice.mob_no',
						'ClientDeviceSubscription.id',
						'ClientDeviceSubscription.subscribe_date',
						'ClientDeviceSubscription.expire_date' 
				),
				'conditions' => array (
						'ClientDevice.deviceid' => $id 
				) 
		) );
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $devices ) 
		) );
	}
	public function getTransferDetail($id = null) {
		$query = "select cc.name, cc.mobile from client_contacts as cc where cc.client_info_id = '$id'";
		$countDeviceQuery = "select count(*) as total_device from client_devices as cd where cd.client_info_id = '$id'";
		
		$dbc = $this->_getConnection ( 'database' );
		$rows = array ();
		$results = $dbc->query ( $query );
		$deviceCountResult = $dbc->query ( $countDeviceQuery );
		if ($deviceCountResult) {
			$count = $deviceCountResult->fetch_assoc ();
		}
		
		if ($results) {
			while ( $row = $results->fetch_assoc () ) {
				$row ['total_device'] = $count ['total_device'];
				$rows [] = $row;
			}
		}
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $rows ) 
		) );
	}
	public function getDeviceInfoByUserId($uid = null) {
		$devices = null;
		$user = $this->User->findById ( $uid );
		$clientId = $user ['User'] ['client_info_id'];
		
		if ($user ['User'] ['user_type_id'] == '5') {
			$deviceids = $this->ClientContactDevice->find ( 'list', array (
					'recursive' => '-1',
					'fields' => array (
							'ClientContactDevice.client_device_id' 
					),
					'conditions' => array (
							'ClientContactDevice.client_contact_id' => $user ['User'] ['client_contact_id'] 
					) 
			) );
			$devices = $this->ClientDevice->find ( 'all', array (
					'fields' => array (
							'ClientDevice.id',
							'ClientDevice.name',
							'VehicleType.name',
							'ClientDevice.active',
							'DeviceType.name',
							'ClientDevice.deviceid' 
					),
					'conditions' => array (
							'ClientDevice.id' => $deviceids 
					) 
			) );
		} else {
			$devices = $this->ClientDevice->find ( 'all', array (
					'fields' => array (
							'ClientDevice.id',
							'ClientDevice.name',
							'VehicleType.name',
							'ClientDevice.active',
							'DeviceType.name',
							'ClientDevice.deviceid' 
					),
					'conditions' => array (
							'ClientDevice.client_info_id' => $clientId 
					) 
			) );
		}
		
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $devices ) 
		) );
	}
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index($id = null, $isTransfer = null) {
		$this->set ( compact ( 'id' ) );
		$this->set ( 'ajaxPlaceholder', $this->getAjaxplaceholder () );
		if ($isTransfer != null) {
			$this->set ( 'transfer', 1 );
		}
		if ($this->getUserRole () != 'admin') {
			$this->set ( 'transfer', 1 );
		}
	}
	
	public function show_all_devices()
	{
		
	}
		
	public function search() {
	}
	public function typehead() {
	}
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function view($id = null) {
		$this->ClientDevice->id = $id;
		if (! $this->ClientDevice->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid client device' ) );
		}
		$this->set ( 'clientDevice', $this->ClientDevice->read ( null, $id ) );
	}
	
	/**
	 * add method
	 *
	 * @return void
	 */
	private function _getDeviceId() {
//		$autid;
		while ( true ) {
			$autid = rand ( 12345678, 98989898 );
			if (! $this->ClientDevice->hasAny ( array (
					'ClientDevice.deviceid' => "$autid" 
			) )) {
				break;
			}
		}
		return $autid;
	}
	public function get_devid() {
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => $this->_getDeviceId () 
		) );
	}
	public function add($id = null) {
		if ($this->request->is ( 'post' )) {
			$deviceid = $this->request->data ['ClientDevice'] ['deviceid'];
			$this->ClientDevice->begin ();
			
			// save subscription as well
			$this->request->data['ClientDeviceSubscription']['client_deviceid'] = $deviceid;
			$this->request->data['ClientDeviceSubscription']['client_info_id'] = $this->request->data['ClientDevice']['client_info_id'];
			
			$this->ClientDevice->ClientDeviceSubscription->create ();
			if ($this->ClientDevice->ClientDeviceSubscription->save($this->request->data)) {

				// pr($this->ClientDevice->ClientDeviceSubscription->id);
				$this->request->data['ClientDevice']['client_device_subscription_id'] = $this->ClientDevice->ClientDeviceSubscription->id;
				
				$this->ClientDevice->create ();
				if ($this->ClientDevice->save($this->request->data)) {
					$flg = $this->_add_device_in_db($deviceid );
					if ($flg == "")
					{
						$this->ClientDevice->commit ();
						$this->Session->setFlash ( __ ( 'The client device has been saved' ), 'flash_success' );
						$this->redirect(array ('action' => 'index', $id));
					} else {
						$this->ClientDevice->rollback ();
						$this->Session->setFlash ( $flg, 'flash_fail' );
					}
				}
			} else {
				$this->Session->setFlash ( __ ( 'The client device could not be saved. Please, try again.' ), 'flash_fail' );
			}
			$this->ClientDevice->rollback ();
		} else {
			$deviceid = $this->_getDeviceId();
			$this->set('deviceid', $deviceid);
		}
		
		$accountTypes = $this->ClientDevice->ClientDeviceSubscription->AccountType->find ( 'list' );
		$deviceTypes = $this->ClientDevice->DeviceInfo->DeviceType->find ( 'list' );
		$vehicleTypes = $this->ClientDevice->VehicleType->find ( 'list' );
		$deviceInfos = $this->ClientDevice->DeviceInfo->find ( 'list', array (
				'conditions' => array (
						'DeviceInfo.device_type_id' => 1 
				) 
		) );
		$this->set ( compact ( 'deviceInfos', 'accountTypes', 'vehicleTypes', 'deviceTypes' ) );
		
		$this->set ( 'client_info_id', $id );
	}
	
	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function edit($id = null) {
		$this->ClientDevice->id = $id;
		
		if (! $this->ClientDevice->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid client device' ) );
		}
		if ($this->request->is ( 'post' ) || $this->request->is ( 'put' )) {
			// calculate expire date
			if ($this->ClientDevice->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The client device has been saved' ), 'flash_success' );
				if (isset ( $this->request->query ['clientid'] )) {
					$clientid = $this->request->query ['clientid'];
					$this->redirect ( array (
							'action' => 'index',
							$clientid 
					) );
				} else {
					$this->redirect ( array (
							'action' => 'search' 
					) );
				}
			} else {
				$this->Session->setFlash ( __ ( 'The client device could not be saved. Please, try again.' ), 'flash_fail' );
			}
		} else {
			$this->request->data = $this->ClientDevice->read ( null, $id );
		}
		// $accountTypes = $this->ClientDevice->AccountType->find('list');
		$deviceTypes = $this->ClientDevice->DeviceInfo->DeviceType->find ( 'list' );
		$vehicleTypes = $this->ClientDevice->VehicleType->find ( 'list' );
		$deviceInfos = $this->ClientDevice->DeviceInfo->find ( 'list' );
		$this->set ( compact ( 'deviceInfos', 'vehicleTypes', 'deviceTypes' ) );
		
		$this->set ( 'client_info_id', $this->request->query ['clientid'] );
	}
	
	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function delete($id = null) {
		// if (!$this->request->is('post')) {
		// throw new MethodNotAllowedException();
		// }
		$clientid = $this->request->query ['clientid'];
		$this->ClientDevice->id = $id;
		if (! $this->ClientDevice->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid client device' ) );
		}
		if ($this->ClientDevice->delete ()) {
			$this->Session->setFlash ( __ ( 'Client device deleted' ), 'flash_success' );
			$this->redirect ( array (
					'action' => 'index',
					$clientid 
			) );
		}
		$this->Session->setFlash ( __ ( 'Client device was not deleted' ), 'flash_fail' );
		$this->redirect ( array (
				'action' => 'index',
				$clientid 
		) );
	}


	public function jsondata() {
		$fields = array (
				'ClientDevice.id',
				'ClientDevice.name',
				'ClientDevice.tracker_id',
				'ClientDevice.mob_no',
				'ClientDevice.deviceid',
				'ClientDeviceSubscription.expire_date',
				'DeviceType.description',
				'DeviceInfo.name',
				'ClientInfo.name',
				'ClientDevice.active',
				'ClientInfo.id' 
		);
		$limit = 10;
		$offset = 0;
		$orderby = array ();
		$and = array ();
		$conditions = array ();
		
		if (isset ( $this->request->query ['iDisplayStart'] ) && $this->request->query ['iDisplayLength'] != '-1') {
			$limit = $this->request->query ['iDisplayLength'];
			$offset = $this->request->query ['iDisplayStart'];
		}
		
		if (isset ( $this->request->query ['iSortCol_0'] )) {
			if ($this->request->query ['iSortCol_0'] == 0) {
				$orderby [] = 'ClientDevice.id DESC';
			} else {
				for($i = 0; $i < intval ( $this->request->query ['iSortingCols'] ); $i ++) {
					if ($_GET ['bSortable_' . intval ( $this->request->query ['iSortCol_' . $i] )] == "true") {
						$orderby [] = $fields [intval ( $this->request->query ['iSortCol_' . $i] )] . " " . $this->request->query ['sSortDir_' . $i];
					}
				}
			}
		}
		
		$and [] = array (
				'1' => 1 
		);
		//
		$role = $this->getUserRole ();
		if ($role == "group") {
			$contactid = $this->getUserContactid ();
			$divids = $this->ClientContactDevice->find ( 'list', array (
					'recursive' => - 1,
					'fields' => array (
							'ClientContactDevice.client_device_id' 
					),
					'conditions' => array (
							'ClientContactDevice.client_contact_id' => $contactid 
					) 
			) );
			
			$and [] = array (
					'ClientDevice.id' => $divids 
			);
		} else {
			$client_info_id = isset ( $this->request->query ['client_info_id'] ) ? $this->request->query ['client_info_id'] : null;
			if ($client_info_id != null) {
				$and [] = array (
						'ClientDevice.client_info_id' => $client_info_id 
				);
			}
		}
		
		if (isset ( $this->request->query ['sSearch'] ) && ! empty ( $this->request->query ['sSearch'] )) {
			$and [] = array (
					'ClientDevice.tracker_id like ' => '%' . $this->request->query ['sSearch'] . '%' 
			);
		}
		
		if (count ( $and ) > 1) {
			$conditions = array (
					'AND' => $and 
			);
		} else {
			$conditions = $and;
		}
		
		$result = $this->ClientDevice->find ( 'all', array (
				'conditions' => $conditions,
				'recursive' => 0,
				'fields' => $fields,
				'order' => $orderby,
				'limit' => $limit,
				'offset' => $offset 
		) );
		// $log = $this->ClientDevice->getDataSource()->getLog(false, false);
		// debug($log);
		
		/* Total data set length */
		$iTotal = $this->ClientDevice->find ( 'count', array (
				'conditions' => $conditions 
		) );
		// $log = $this->ClientDevice->getDataSource()->getLog(false, false);
		// debug($log);
		$output = array (
				"sEcho" => intval ( $this->request->query ['sEcho'] ),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData" => array () 
		);
		
		for($j = 0; $j < count ( $result ); $j ++) {
			{
				$row = array ();
				for($i = 0; $i < count ( $fields ); $i ++) {
					if ($fields [$i] != ' ') {
						$fld = explode ( '.', $fields [$i] );
						$row [] = $result [$j] [$fld [0]] [$fld [1]];
					}
				}
				$row [] = "";
				$output ['aaData'] [] = $row;
			}
		}
		return new CakeResponse ( array (
				'body' => json_encode ( $output ) 
		) );
	}
	public function jsondata_all_devices() {
		$fields = array (
				'ClientDevice.id',
				'ClientDevice.name',
				'ClientDevice.tracker_id',
				'ClientDevice.mob_no',
				'ClientDevice.deviceid',
				'ClientDeviceSubscription.expire_date',
				'DeviceType.description',
				'DeviceInfo.name',
				'ClientInfo.name',
				'ClientDevice.active',
				'ClientInfo.id' 
		);
		//$limit = 25;
		$offset = 0;
		$orderby = array ();
		$and = array ();
		$conditions = array ();
		
		if (isset ( $this->request->query ['iDisplayStart'] ) && $this->request->query ['iDisplayLength'] != '-1') {
			$limit = $this->request->query ['iDisplayLength'];
			$offset = $this->request->query ['iDisplayStart'];
		}
		
		if (isset ( $this->request->query ['iSortCol_0'] )) {
			if ($this->request->query ['iSortCol_0'] == 0) {
				$orderby [] = 'ClientDevice.id DESC';
			} else {
				for($i = 0; $i < intval ( $this->request->query ['iSortingCols'] ); $i ++) {
					if ($_GET ['bSortable_' . intval ( $this->request->query ['iSortCol_' . $i] )] == "true") {
						$orderby [] = $fields [intval ( $this->request->query ['iSortCol_' . $i] )] . " " . $this->request->query ['sSortDir_' . $i];
					}
				}
			}
		}
		
		$and [] = array (
				'1' => 1 
		);
		
		if (isset ( $this->request->query ['sSearch'] ) && ! empty ( $this->request->query ['sSearch'] )) {
			$and [] = array (
					'ClientDevice.tracker_id like ' => '%' . $this->request->query ['sSearch'] . '%' 
			);
		}
		
		if (count ( $and ) > 1) {
			$conditions = array (
					'AND' => $and 
			);
		} else {
			$conditions = $and;
		}
		
		$result = $this->ClientDevice->find ( 'all', array (
				'conditions' => $conditions,
				'recursive' => 0,
				'fields' => $fields,
				'order' => $orderby,
				'limit' => $limit,
				'offset' => $offset 
		) );
		// $log = $this->ClientDevice->getDataSource()->getLog(false, false);
		// debug($log);
		
		/* Total data set length */
		$iTotal = $this->ClientDevice->find ( 'count', array (
				'conditions' => $conditions 
		) );
		// $log = $this->ClientDevice->getDataSource()->getLog(false, false);
		// debug($log);
		$output = array (
				"sEcho" => intval ( $this->request->query ['sEcho'] ),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData" => array () 
		);
		
		for($j = 0; $j < count ( $result ); $j ++) {
			{
				$row = array ();
				for($i = 0; $i < count ( $fields ); $i ++) {
					if ($fields [$i] != ' ') {
						$fld = explode ( '.', $fields [$i] );
						$row [] = $result [$j] [$fld [0]] [$fld [1]];
					}
				}
				$row [] = "";
				$output ['aaData'] [] = $row;
			}
		}
		return new CakeResponse ( array (
				'body' => json_encode ( $output ) 
		) );
	}
	public function jsondata_acc() {
		$fields = array (
				'cd.id',
				'cd.name',
				'cd.mob_no',
				'cd.deviceid',
				'cd.tracker_id',
				'cds.expire_date',
				'cd.active' 
		);
		$limit = 10;
		$offset = 0;
		$orderby = array ();
		$and = array ();
		$conditions = array ();
		
		$and [] = array (
				'1' => 1 
		);
		//
		$role = $this->getUserRole ();
		if ($role == "accounts") {
			$type = $this->request->query ['client_info_id'];
			if ($type == 7) {
				$and [] = array (
						'ClientDeviceSubscription.expire_date BETWEEN ' . $this->request->query ['fromdate'] . ' AND ' . $this->request->query ['todate'] 
				);
			}
		}
		
		if (count ( $and ) > 1) {
			$conditions = array (
					'AND' => $and 
			);
		} else {
			$conditions = $and;
		}
		
		$d = $this->request->query ['fromdate'];
		$t = $this->request->query ['todate'];
		$sql = "SELECT 
					cd.id,
					cd.name,
					cd.mob_no,
					cd.deviceid,
					cd.tracker_id,
					cds.expire_date,
					cd.active
				FROM client_devices as cd
					join client_device_subscriptions as cds on cds.id = cd.client_device_subscription_id
				WHERE cds.expire_date between '$d' and '$t'
					order by cds.expire_date";
		
		$result = $this->ClientDevice->query ( $sql );
		
		/* Total data set length */
		// $iTotal = $this->ClientDevice->find('count',array($conditions));
		
		$sQuery = " SELECT FOUND_ROWS() ";
		
		/* Total data set length */
		// $iTotal = $this->ClientDevice->find('count',array($conditions));
		$iTotal = $this->ClientDevice->query ( $sQuery );
		
		$output = array (
				"sEcho" => 1,
				"iTotalRecords" => $iTotal [0] [0] ['FOUND_ROWS()'],
				"iTotalDisplayRecords" => $iTotal [0] [0] ['FOUND_ROWS()'],
				"aaData" => array () 
		);
		
		for($j = 0; $j < count ( $result ); $j ++) {
			{
				$row = array ();
				for($i = 0; $i < count ( $fields ); $i ++) {
					if ($fields [$i] != ' ') {
						$fld = explode ( '.', $fields [$i] );
						pr ( $result [$j] [$fld [0]] [$fld [1]] );
						$row [] = $result [$j] [$fld [0]] [$fld [1]];
					}
				}
				$row [] = "";
				$output ['aaData'] [] = $row;
			}
		}
		return new CakeResponse ( array (
				'body' => json_encode ( $output ) 
		) );
	}
	private function _add_device_in_db($deviceid) {
		$dbc = $this->_getConnection ('dbdevices');
		if ($dbc == null) {
			return "Fail to connect DB.";
		} else {
			$flg = $this->_create_devicetbl($dbc, $deviceid);
			if ($flg == "") {
				$flg = $this->_create_devicetrgr($dbc, $deviceid);
				if ($flg == "") {
					$flg = $this->_insert_devicetrgr($dbc, $deviceid);
				}
			}
			$this->_closeConnection ( $dbc );
		}
		return $flg;
	}
	private function _insert_devicetrgr($dbc, $deviceid) {
		$sql = "INSERT INTO `devicetracks1` (`deviceid`)VALUES ('" . $deviceid . "') ON DUPLICATE KEY UPDATE  `deviceid` = '" . $deviceid . "';";
		$result = $this->_execute ( $dbc, $sql );
		if (! $result) {
			// printf("Errormessage: %s\n", $dbc->error);
			return $dbc->error;
		}
		$sql = "INSERT INTO `devicetracks2` (`deviceid`)VALUES ('" . $deviceid . "') ON DUPLICATE KEY UPDATE  `deviceid` = '" . $deviceid . "';";
		$result = $this->_execute ( $dbc, $sql );
		if (! $result) {
			// printf("Errormessage: %s\n", $dbc->error);
			return $dbc->error;
		}
		return "";
	}
	private function _create_devicetrgr($dbc, $deviceid) {
		$sql = "DROP TRIGGER IF EXISTS `" . $deviceid . "_after_insert`;";
		$result = $this->_execute ( $dbc, $sql );
		if (! $result) {
			// printf("Errormessage: %s\n", $dbc->error);
			return $dbc->error;
		}
		$sql = "
				CREATE TRIGGER `d" . $deviceid . "_after_insert` AFTER INSERT ON `d" . $deviceid . "`
						FOR EACH ROW
						BEGIN
						UPDATE `devicetracks1`
						SET `event_number` = NEW.`event_number`,
						`device_time` = NEW.`device_time`,
						`server_time` = NEW.`server_time`,
						`device_date` = NEW.`device_date`,
						`server_date` = NEW.`server_date`,
						`latitude` = NEW.`latitude`,
						`longitude` = NEW.`longitude`,
						`altitude` = NEW.`altitude`,
						`speed` = NEW.`speed`,
						`direction` = NEW.`direction`,
						`odometer` = NEW.`odometer`,
						`hdop` = NEW.`hdop`,
						`fuel` = NEW.`fuel`,
						`sat_cnt` = NEW.`sat_cnt`,
						`veh_status` = NEW.`veh_status`,
						`msg_id` = NEW.`msg_id`,
						`msg_info` = NEW.`msg_info`,
						`reserve1` = NEW.`reserve1`,
						`reserve2` = NEW.`reserve2`,
						`reserve3` = NEW.`reserve3`,
						`reserve4` = NEW.`reserve4`,
						`reserve5` = NEW.`reserve5`,
						`reserve6` = NEW.`reserve6`,
						`reserve7` = NEW.`reserve7`,
						`reserve8` = NEW.`reserve8`,
						`reserve9` = NEW.`reserve9`,
						`reserve10` = NEW.`reserve10`
						WHERE `deviceid` = \"" . $deviceid . "\";
								END;
								";
		// echo $sql;
		$result = $this->_execute ( $dbc, $sql );
		if (! $result) {
			return $dbc->error;
		}
		return "";
	}
	private function _create_devicetbl($dbc, $deviceid) {
		$sql = "DROP TABLE IF EXISTS `d" . $deviceid . "`;";
		$result = $this->_execute ( $dbc, $sql );
		if (! $result) {
			// printf("Errormessage: %s\n", $dbc->error);
			return $dbc->error;
		}
		$sql = "
				CREATE TABLE `d" . $deviceid . "` (
				  `event_number` BIGINT NOT NULL AUTO_INCREMENT,
				  `device_time` time DEFAULT NULL,
				  `server_time` time DEFAULT NULL,
				  `device_date` date DEFAULT NULL,
				  `server_date` date DEFAULT NULL,
				  `latitude` varchar(36) DEFAULT NULL,
				  `longitude` varchar(36) DEFAULT NULL,
				  `altitude` varchar(36) DEFAULT NULL,
				  `speed` varchar(24) DEFAULT NULL,
				  `direction` varchar(60) DEFAULT NULL,
				  `odometer` varchar(60) DEFAULT NULL,
				  `hdop` varchar(60) DEFAULT NULL,
				  `fuel` varchar(24) DEFAULT NULL,
				  `sat_cnt` varchar(60) DEFAULT NULL,
				  `veh_status` varchar(60) DEFAULT NULL,
				  `msg_id` varchar(60) DEFAULT NULL,
				  `msg_info` varchar(150) DEFAULT NULL,
				  `reserve1` varchar(24) DEFAULT NULL,
				  `reserve2` varchar(24) DEFAULT NULL,
				  `reserve3` varchar(24) DEFAULT NULL,
				  `reserve4` VARCHAR(24) DEFAULT NULL,
				  `reserve5` VARCHAR(24) DEFAULT NULL,
				  `reserve6` VARCHAR(24) DEFAULT NULL,
				  `reserve7` VARCHAR(24) DEFAULT NULL,
				  `reserve8` VARCHAR(24) DEFAULT NULL,
				  `reserve9` VARCHAR(24) DEFAULT NULL,
				  `reserve10` VARCHAR(24) DEFAULT NULL,
				  PRIMARY KEY (`event_number`),
						INDEX  `d" . $deviceid . "_server_date`(`server_date`),
								INDEX  `d" . $deviceid . "_server_time`(`server_date`),
										INDEX  `d" . $deviceid . "_server_datetime`(`server_date`,`server_time`),
												INDEX  `d" . $deviceid . "_lat_lng`(`latitude`,`longitude`)
														) ENGINE=MyISAM DEFAULT CHARSET=latin1;
														";
		// echo $sql;
		$result = $this->_execute ( $dbc, $sql );
		if (! $result) {
			return $dbc->error;
		}
		return "";
	}
	public function acc_index($index = 0) {
		$this->set ( 'index', $index );
		$this->set ( 'role', $this->getUserRole () );
	}
	public function res_index($index = 0) {
		$this->set ( 'index', $index );
	}
	public function updateSubscription() {
		$deviceId = $this->request->query ['deviceid'];
		$sData = $this->ClientDeviceSubscription->findByClientDeviceid ( $deviceId );
		return new CakeResponse ( array (
				'body' => json_encode ( $sData ['ClientDeviceSubscription'] ),
				'type' => "application/json" 
		) );
	}
	public function transfer($id = null) {
		if ($this->request->is ( 'post' )) {
			$device = $this->ClientDevice->findByDeviceid ( $this->request->data ['deviceid'] );
			$device ['ClientDevice'] ['client_info_id'] = $this->request->data ['client_id'];
			$device ['ClientDevice'] ['name'] = $this->request->data ['reg'];
			if ($this->ClientDevice->save ( $device )) {
				$this->Session->setFlash ( __ ( 'The client device transfer has been saved' ), 'flash_success' );
			} else {
				$this->Session->setFlash ( __ ( 'Error with device transfer. Please try again !!!' ), 'flash_fail' );
			}
		}
	}
	public function unitSimDevice() {
		
	}
	
	public function transferDeviceToSingleUser($id = null) {
		//
		if ($this->request->is ( 'post' )) {
			$device = $this->ClientDevice->findByDeviceid ( $this->request->data ['device_id'] );
			$device ['ClientDevice'] ['client_info_id'] = $this->request->data ['to_client_id'];
			$device ['ClientDevice'] ['name'] = $this->request->data ['to_reg_no'];
			if ($this->ClientDevice->save ( $device )) 
			{
				$this->TransferHistory->create();
				$data = array();
				$data['from_user_id'] = $this->request->data['from_user_id'];
				$data['from_client_info_id'] = $this->request->data['from_client_id'];
				$data['to_user_id'] = $this->request->data['to_user_id'];
				$data['to_client_info_id'] = $this->request->data['to_client_id'];
				$data['from_veh_reg_no'] = $this->request->data['from_reg_no'];
				$data['to_veh_reg_no'] = $this->request->data['to_reg_no'];
				$data['device_id'] = $this->request->data['device_id'];
				$user = $this->Auth->user();
				$data['transfered_by_id'] = $user['id'];
				if($this->TransferHistory->save($data))
				{
					$this->Session->setFlash ( __ ( 'The client device transfer has been saved' ), 'flash_success' );
					$this->redirect ( array (
							'action' => 'show_all_devices'
					) );
				}
				
			} else {
				$this->Session->setFlash ( __ ( 'Error with device transfer.Please try again !!!' ), 'flash_fail' );
			}
		}
		else {
			$this->set ( 'deviceId', $id );
			
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
	}
	
	public function get_all_device_list_json() {		
		//
		$query = "select cd.id, cd.name, cd.tracker_id, cd.mob_no, cd.deviceid, cd.active
				  from client_devices as cd";
		//
		$result = $this->ClientDevice->query($query);
		
		$iTotal = count($result);
		$output = array(
				"sEcho" => intval($this->request->query['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData" => array()
		);
		
		//
		foreach ($result as $r) {
			$row = array();
			$row[] = $r['cd']['id'];
			$row[] = $r['cd']['name'];
			$row[] = $r['cd']['tracker_id'];
			$row[] = $r['cd']['mob_no'];
			$row[] = $r['cd']['deviceid'];
			$row[] = $r['cd']['active'];
			$row[] = "";
			$output['aaData'][] = $row;
		}
		
		//
		return new CakeResponse(array('body' => json_encode($output)));
	}
	
	public function get_all_device_list_by_client_json($client_info_id=null) 
	{
		//
		$query = "select cd.id, cd.name, cd.tracker_id, cd.mob_no, cd.deviceid, cd.active
				  from client_devices as cd where cd.client_info_id='$client_info_id'";
		
		//
		$result = $this->ClientDevice->query($query);

		//
		$iTotal = count($result);
		$output = array(
				"sEcho" => intval($this->request->query['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData" => array()
		);
		
		foreach ($result as $r) 
		{
			$row = array();
			$row[] = $r['cd']['id'];
			$row[] = $r['cd']['name'];
			$row[] = $r['cd']['tracker_id'];
			$row[] = $r['cd']['mob_no'];
			$row[] = $r['cd']['deviceid'];
			$row[] = $r['cd']['active'];
			$row[] = "";
			$output['aaData'][] = $row;
		}
		return new CakeResponse(array('body' => json_encode($output)));
	}
	
}
