<?php
App::uses('AppController', 'Controller');
/**
 * ClientInfos Controller
 *
 * @property ClientInfo $ClientInfo
*/
class ClientInfosController extends AppController {

	var $uses = array('ClientContact', 'ClientInfo','ClientAlertSetting','AlertType', 'User', 'ClientDevice');

	public function showClientInfo(){
		$clientid = '';
		if(isset($this->request->query['contactid']))
		{
			$contactid =  $this->request->query['contactid'];
			$clientid = $this->ClientContact->find('first',array('fields'=>'ClientContact.client_info_id', 'conditions'=>array('ClientContact.id'=>$contactid)));
			$clientid = $clientid['ClientContact']['client_info_id'];
		}
		else if(isset($this->request->query['clientid']))
		{
			$clientid =  $this->request->query['clientid'];
		}
		else if(isset($this->request->query['userid']))
		{
			$userid =  $this->request->query['userid'];
			$clientid = $this->ClientInfo->User->find('first',array('fields'=>'User.client_info_id', 'conditions'=>array('User.id'=>$userid)));
			$clientid = $clientid['User']['client_info_id'];
		}
		$this->redirect(array('action' => 'view',$clientid));
			
	}

	public function showClientInfoStaticSearch(){
		$clientid = '';
		if(isset($this->request->query['username']))
		{
			$username =  $this->request->query['username'];
			$clientid = $this->ClientInfo->User->find('first',array('fields'=>'User.client_info_id', 'conditions'=>array('User.username'=>$username)));
			$clientid = $clientid['User']['client_info_id'];
		}
		else if(isset($this->request->query['deviceid']))
		{
			$deviceid =  $this->request->query['deviceid'];
			$clientid = $this->ClientDevice->find('first',array('fields'=>'ClientDevice.client_info_id', 'conditions'=>array('ClientDevice.deviceid'=>$deviceid)));
			$clientid = $clientid['ClientDevice']['client_info_id'];
		}
		else if(isset($this->request->query['rgn']))
		{
			$rgn =  $this->request->query['rgn'];
			$clientid = $this->ClientDevice->find('first',array('fields'=>'ClientDevice.client_info_id', 'conditions'=>array('ClientDevice.name'=>$rgn)));
			$clientid = $clientid['ClientDevice']['client_info_id'];
		}
		else if(isset($this->request->query['sim']))
		{
			$sim =  $this->request->query['sim'];
			$clientid = $this->ClientDevice->find('first',array('fields'=>'ClientDevice.client_info_id', 'conditions'=>array('ClientDevice.mob_no'=>$sim)));
			$clientid = $clientid['ClientDevice']['client_info_id'];
		}
		else if(isset($this->request->query['trackerid']))
		{
			$trackerid =  $this->request->query['trackerid'];
			$clientid = $this->ClientDevice->find('first',array('fields'=>'ClientDevice.client_info_id', 'conditions'=>array('ClientDevice.tracker_id'=>$trackerid)));
			$clientid = $clientid['ClientDevice']['client_info_id'];
		}
		if(isset($this->request->query['cm']))
		{
			$cm =  $this->request->query['cm'];
			$clientid = $this->ClientContact->find('first',array('fields'=>'ClientContact.client_info_id', 'conditions'=>array('ClientContact.mobile'=>$cm)));
			$clientid = $clientid['ClientContact']['client_info_id'];
		}
		$this->redirect(array('action' => 'view',$clientid));
			
	}

	public function index() {

	}

	public function view($id = null) {
		$this->ClientInfo->id = $id;
		if (!$this->ClientInfo->exists()) {
			throw new NotFoundException(__('Invalid client info'));
		}
		$client = $this->ClientInfo->read(null, $id);
		if($client['ClientInfo']['client_type_id'] == 1){
			$deviceCount = $this->ClientDevice->find('count', array('conditions'=>array('ClientDevice.client_info_id'=>$client['ClientInfo']['id'])));
			if($deviceCount > 0){
				$this->set('devicecountflag', $deviceCount);
			}
		}
		$this->set('clientInfo', $client);
	}

	public function logo($clientid = null){
		if($clientid==null){
			$clientid = $this->getUserClientid();
		}
		$this->ClientInfo->id = $clientid;
		if (!$this->ClientInfo->exists()) {
			throw new NotFoundException(__('Invalid client info'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			$this->request->data['ClientInfo']['company_type_id'] = null;
			$this->request->data['ClientInfo']['filename']['id'] = $this->request->data['ClientInfo']['id'];

			if ($this->ClientInfo->save($this->request->data)) {
				$this->Session->setFlash(__('Client logo successfully uploaded.'), 'flash_success');
			}
			else{
				$this->Session->setFlash(__('Fail to upload logo.'), 'flash_fail');
			}
		}
		else {
			$this->request->data = $this->ClientInfo->read(null, $clientid);
		}
		$this->set('id', $clientid);
		//$this->layout = 'ajax';
	}

	public function add() {
		if ($this->request->is('post')) {
			$valid = false;
			if($this->request->data['ClientInfo']['client_type_id']==1){
				$this->request->data['User']['user_type_id'] = 4;
			}else{
				$this->request->data['User']['user_type_id'] = 3;
			}
			$this->ClientInfo->User->set($this->request->data);
			if($this->ClientInfo->User->validates()){

				$this->ClientInfo->set($this->request->data);
				if($this->ClientInfo->validates()){

					if(($this->request->data['ClientInfo']['client_type_id']==1) && empty($this->request->data['ClientContact']['name'])){
						$this->request->data['ClientContact']['name'] = $this->request->data['ClientInfo']['name'];
					}
					$this->ClientInfo->ClientContact->set($this->request->data);
					if($this->ClientInfo->ClientContact->validates()){
						$valid = true;
					}
				}
			}
			if($valid){
				$this->ClientInfo->begin();

				$userid = String::uuid();
				$contactid = String::uuid();
				$clientid = String::uuid();

				$this->request->data['User']['id'] = $userid;
				$this->request->data['User']['client_contact_id'] = $contactid;
				$this->request->data['User']['client_info_id'] = $clientid;
				$this->ClientInfo->User->create();
				if ($this->ClientInfo->User->save($this->request->data)) {

					$this->request->data['ClientContact']['id'] = $contactid;
					$this->request->data['ClientContact']['user_id'] = $userid;
					$this->request->data['ClientContact']['client_info_id'] = $clientid;
					$this->ClientInfo->ClientContact->create();
					if ($this->ClientInfo->ClientContact->save($this->request->data)) {

						$this->request->data['ClientInfo']['id'] = $clientid;
						$this->request->data['ClientInfo']['user_id'] = $userid;
						$this->request->data['ClientInfo']['client_contact_id'] = $contactid;
						$this->ClientInfo->create();
						if ($this->ClientInfo->save($this->request->data)) {
							$flg = true;

							$alerts = $this->AlertType->find('list');
							$data['client_info_id'] = $clientid;

							foreach($alerts as $key => $value){
								$data['alert_type_id'] = $key;
								$data['client_contact_id'] = $contactid;
								$data['alert_by'] = 'email';
								$this->ClientAlertSetting->create();
								if(!$this->ClientAlertSetting->save($data)){
									$flg = false;
									break;
								}
							}

							if($flg){
								$this->ClientInfo->commit();
								$this->Session->setFlash(__('The client info has been saved'), 'flash_success');
								$this->redirect(array('action' => 'index'));
							}
						}
					}
				}
				$this->ClientInfo->rollback();
				$this->Session->setFlash(__('The client info could not be saved. Please, try again.'), 'flash_fail');
			}
			else
			{
				$this->Session->setFlash(__('Please fix the inputs below.'), 'flash_fail');
			}
		}
		$clientTypes = $this->ClientInfo->ClientType->find('list');
		$companyTypes = $this->ClientInfo->CompanyType->find('list');
		$this->set(compact('clientTypes', 'companyTypes'));
	}

	public function edit($id = null) {
		if($id==null){
			$id = $this->getUserClientid();
		}
		$this->ClientInfo->id = $id;
		if (!$this->ClientInfo->exists()) {
			throw new NotFoundException(__('Invalid client info'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$valid = false;

			$this->ClientInfo->set($this->request->data);
			if($this->ClientInfo->validates()){

				$this->ClientInfo->ClientContact->set($this->request->data);
				if($this->ClientInfo->ClientContact->validates()){
					$valid = true;
				}
			}
			if($valid){
				$this->ClientInfo->begin();
				$this->request->data['ClientContact']['client_info_id'] = $id;
				$user = $this->Auth->user();
				$this->request->data['ClientContact']['user_id'] = $user['id'];
				if ($this->ClientInfo->ClientContact->save($this->request->data)) {

					if ($this->ClientInfo->save($this->request->data)) {
						$this->ClientInfo->commit();
						$this->Session->setFlash(__('The client info has been saved'), 'flash_success');
						$this->redirect(array('action' => 'index'));
					}
				}
				$this->ClientInfo->rollback();
				$this->Session->setFlash(__('The client info could not be saved. Please, try again.'), 'flash_fail');
			}else{
				$this->Session->setFlash(__('Please fix the inputs below.'), 'flash_fail');
				$this->request->data = $this->ClientInfo->read(null, $id);
			}
		} else {
			$this->request->data = $this->ClientInfo->read(null, $id);
		}
		$clientTypes = $this->ClientInfo->ClientType->find('list');
		$companyTypes = $this->ClientInfo->CompanyType->find('list');
		$this->set(compact('clientTypes', 'companyTypes'));
	}


	public function delete($id = null) {
		//if (!$this->request->is('post')) {
		//	throw new MethodNotAllowedException();
		//}
		$this->ClientInfo->id = $id;
		if (!$this->ClientInfo->exists()) {
			throw new NotFoundException(__('Invalid client info'));
		}
		if ($this->ClientInfo->delete()) {
			$this->Session->setFlash(__('Client info deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Client info was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function jsondata(){

		$fields = array('ClientInfo.id','User.username','ClientType.name','ClientInfo.name','ClientInfo.address','ClientContact.phone','ClientContact.mobile','ClientContact.email','ClientContact.fax');
		$limit = 10;
		$offset = 0;
		$orderby = array();
		$and = array();
		$conditions = array();

		if ( isset( $this->request->query['iDisplayStart'] ) && $this->request->query['iDisplayLength'] != '-1' )
		{
			$limit = $this->request->query['iDisplayLength'];
			$offset = $this->request->query['iDisplayStart'];
		}

		if ( isset( $this->request->query['iSortCol_0'] ) )
		{
			if($this->request->query['iSortCol_0'] == 0){
				$orderby[] = 'ClientInfo.modified desc';
			}
			else{
				for ( $i=0 ; $i<intval( $this->request->query['iSortingCols'] ) ; $i++ )
				{
					if ( $_GET[ 'bSortable_'.intval($this->request->query['iSortCol_'.$i]) ] == "true" )
					{
						$orderby[] = $fields[ intval( $this->request->query['iSortCol_'.$i] ) ]." ".$this->request->query['sSortDir_'.$i];
					}
				}
			}
		}

		$and[] = array('1'=>1);
		//
		if ( isset( $this->request->query['sSearch'] ) )
		{
			$and[] = array('User.username like '=>'%'.$this->request->query['sSearch'].'%');
		}
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}

		$result = $this->ClientInfo->find('all',
				array(
						'conditions' => $conditions,
						'recursive' => 0,
						'fields' => $fields,
						'order' => $orderby,
						'limit' => $limit,
						'offset' => $offset,
				)
		);

		//$log = $this->ClientInfo->getDataSource()->getLog(false, false);
		//pr($log);

		/* Total data set length */
		$iTotal = $this->ClientInfo->find('count',array('conditions' => $conditions));

		$output = array(
				"sEcho" => intval($this->request->query['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData" => array()
		);

		for($j=0;$j<count($result);$j++) {
			{
				$row = array();

				for ( $i=0 ; $i<count($fields) ; $i++ )
				{
					if ( $fields[$i] != ' ' )
					{
						$fld = explode( '.', $fields[$i] );
						$row[] = $result[$j][$fld[0]][$fld[1]];
					}
				}
				$row[] = "";
				$output['aaData'][] = $row;
			}
		}
		return new CakeResponse(array('body' => json_encode($output)));
	}

	public function transfer($id=null){
		if ($this->request->is('post'))
		{
			$this->ClientInfo->id = $id;
			$client = $this->ClientInfo->read(null, $id);
			$client['ClientInfo']['client_type_id'] = 2;
			if ($this->ClientInfo->save($client)) {

				$user = $this->User->findByClientInfoId($id);
				$this->User->id = $user['User']['id'];
				$this->User->set('user_type_id', 3);
				$this->User->save();

				$this->Session->setFlash(__('The client transfer into group has been successful.'), 'flash_success');
			}
			else{
				$this->Session->setFlash(__('Transfer Process in not completed.Please try again.'), 'flash_fail');
			}
		}
	}

	public function transfergroup(){

	}

	public function transferToGroupClient($singleId = null, $groupId = null){
		$clientUser = $this->User->findByClientInfoId($singleId);
		if(empty($clientUser)){
			$this->Session->setFlash(__('Client not found !!!'), 'flash_fail');
			$this->redirect(array('action'=>'transfergroup'));
		}
		$this->User->id = $clientUser['User']['id'];
		$this->User->set('user_type_id', 5);
		$this->User->set('client_info_id', $groupId);

		$this->ClientContact->id = $clientUser['ClientContact']['id'];
		$clientUser['ClientContact']['client_info_id'] = $groupId;

		$clientDevice = $this->ClientDevice->findByClientInfoId($singleId);
		if(!empty($clientDevice)){
			$this->ClientDevice->id = $clientDevice['ClientDevice']['id'];
			$clientDevice['ClientDevice']['client_info_id'] = $groupId;
		}

		if($this->ClientContact->save($clientUser)){
			if($this->User->save()){
				
				if(!empty($clientDevice)){
					$this->ClientDevice->save($clientDevice);

					$CDSs = $this->ClientDeviceSubscription->find('all',array('conditions'=>array('ClientDeviceSubscription.client_info_id'=>$singleId,'ClientDeviceSubscription.client_deviceid'=>$clientDevice['ClientDevice']['deviceid'])));
					foreach ($CDSs as $CDS){
						$this->ClientDeviceSubscription->id = $CDS['ClientDeviceSubscription']['id'];
						$CDS['ClientDeviceSubscription']['client_info_id'] = $groupId;
						$this->ClientDeviceSubscription->save($CDS);
					}
				}
				$this->ClientInfo->id = $singleId;
				$this->ClientInfo->delete();
				$this->Session->setFlash(__('The client transfer into group has been successful.'), 'flash_success');
				$this->redirect(array('action'=>'empty_page','controller'=>'users'));
			}
			else{
				$this->ClientContact->id = $clientUser['ClientContact']['id'];
				$clientUser['ClientContact']['client_info_id'] = $singleId;
				$this->ClientContact->save($clientUser);

				$this->Session->setFlash(__('Error Occurred with Client Transfer. Please try again!!!'), 'flash_fail');
				$this->redirect(array('action'=>'transfergroup'));
			}
		}
		else{
			$this->Session->setFlash(__('Error Occurred with Client Transfer. Please try again!!!'), 'flash_fail');
			$this->redirect(array('action'=>'transfergroup'));
		}
	}


}
