<?php
App::uses('AppController', 'Controller');
/**
 * ClientContactDevices Controller
 *
 * @property ClientContactDevice $ClientContactDevice
 */
class ClientContactDevicesController extends AppController {
	var $uses = array('ClientDevice','ClientContactDevice');

/**
 * index method
 *
 * @return void
 */
	public function index($clientid = null) {
		
		$this->set('ajaxPlaceholder',$this->getAjaxplaceholder());
		//get contacts
		$contacts = $this->ClientContactDevice->ClientContact->find('list',array('conditions'=>array('ClientContact.client_info_id'=>$clientid)));
		//get devices
		$devices = $this->ClientContactDevice->ClientDevice->find('list',array('conditions'=>array('ClientDevice.client_info_id'=>$clientid)));
		$this->set(compact('clientid','contacts','devices'));
	}
	public function getDeviceidInfos($id=null){
		$deviceids = $this->ClientContactDevice->find('list',array('recursive'=>'-1','fields'=>array('ClientContactDevice.client_device_id'), 'conditions'=>array('ClientContactDevice.client_contact_id'=>$id)));
		$devices = $this->ClientDevice->find('all',array('fields'=>array('ClientDevice.id','ClientDevice.name','VehicleType.name','ClientDevice.active','DeviceType.name','ClientDevice.deviceid'),'conditions'=>array('ClientDevice.id'=>$deviceids)));
		
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($devices)));		
	}
	public function get_devices($id=null){
		$devices = $this->ClientContactDevice->find('list',array('conditions'=>array('ClientContactDevice.client_contact_id'=>$id,'ClientContactDevice.active'=>true)));
		return new CakeResponse(array('body' => json_encode($devices)));
	}
	public function get_device_names($id=null){
		$devices = $this->ClientContactDevice->find('all',array('fields'=>array('ClientContactDevice.id','ClientDevice.name'), 'conditions'=>array('ClientContactDevice.client_contact_id'=>$id,'ClientContactDevice.active'=>true)));
		return new CakeResponse(array('body' => json_encode($devices)));
	}
	public function save(){
		$clientid = $this->request->data['client_info_id'];
		$contactid = $this->request->data['client_contact_id'];
		$newdevices = $this->request->data['client_device_id'];
		$data = array();
		
		$olddevices = $this->ClientContactDevice->find('all',array('recursive'=>'-1', 'fields'=>array('ClientContactDevice.id','ClientContactDevice.client_device_id','ClientContactDevice.active'), 'conditions'=>array('ClientContactDevice.client_contact_id'=>$contactid)));
		$olddevs = array();
		foreach($olddevices as $k){
			$olddevs[] = $k['ClientContactDevice']['client_device_id'];
			$flg = in_array($k['ClientContactDevice']['client_device_id'], $newdevices);
			if($k['ClientContactDevice']['active'] != $flg){
				$t = array();
				$t['id'] = $k['ClientContactDevice']['id'];			
				$t['active'] = $flg;
				$data[] = $t;		
			}									
		}
		foreach($newdevices as $v){
			$flg = in_array($v, $olddevs);
			if(!$flg){
				$t = array();
				$t['client_info_id'] = $clientid;
				$t['client_contact_id'] = $contactid;
				$t['client_device_id'] = $v;
				$t['active'] = true;
				$data[] = $t;
			}
		}
		$this->ClientContactDevice->begin();
		$flg = true;
		foreach($data as $dt){
			if(!isset($dt['id'])){
				$this->ClientContactDevice->create();	
			}			
			if ($this->ClientContactDevice->save($dt)) {
				$flg = true;						
			} else {
				$flg = false;	
			}			
		}
		if($flg){
			$this->ClientContactDevice->commit();
			$this->Session->setFlash(__('Device added successfully.'), 'flash_success');
			return new CakeResponse(array('body' => 'SUCCESS'));
		}else{
			$this->ClientContactDevice->rollback();
			return new CakeResponse(array('body' => 'ERROR'));
		}
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ClientContactDevice->id = $id;
		if (!$this->ClientContactDevice->exists()) {
			throw new NotFoundException(__('Invalid client contact device'));
		}
		$this->set('clientContactDevice', $this->ClientContactDevice->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClientContactDevice->create();
			if ($this->ClientContactDevice->save($this->request->data)) {
				$this->Session->setFlash(__('The client contact device has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client contact device could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$clientContacts = $this->ClientContactDevice->ClientContact->find('list');
		$clientDevices = $this->ClientContactDevice->ClientDevice->find('list');
		$this->set(compact('clientContacts', 'clientDevices'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ClientContactDevice->id = $id;
		if (!$this->ClientContactDevice->exists()) {
			throw new NotFoundException(__('Invalid client contact device'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClientContactDevice->save($this->request->data)) {
				$this->Session->setFlash(__('The client contact device has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client contact device could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ClientContactDevice->read(null, $id);
		}
		$clientContacts = $this->ClientContactDevice->ClientContact->find('list');
		$clientDevices = $this->ClientContactDevice->ClientDevice->find('list');
		$this->set(compact('clientContacts', 'clientDevices'));
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
		//if (!$this->request->is('post')) {
		//	throw new MethodNotAllowedException();
		//}
		$this->ClientContactDevice->id = $id;
		if (!$this->ClientContactDevice->exists()) {
			throw new NotFoundException(__('Invalid client contact device'));
		}
		if ($this->ClientContactDevice->delete()) {
			$this->Session->setFlash(__('Client contact device deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Client contact device was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){

		$fields = array('ClientContactDevice.field1','ClientContactDevice.field2','...');
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
			for ( $i=0 ; $i<intval( $this->request->query['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($this->request->query['iSortCol_'.$i]) ] == "true" )
				{
					$orderby[] = $fields[ intval( $this->request->query['iSortCol_'.$i] ) ]." ".$this->request->query['sSortDir_'.$i];
				}
			}
		}


		$and[] = array('1'=>1);		
		// 
					
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
		 
		$result = $this->ClientContactDevice->find('all',
									array(
										'conditions' => $conditions,
									    'recursive' => 0,
									    'fields' => $fields,
									    'order' => $orderby,
									    'limit' => $limit,
									    'offset' => $offset,
									)
									);

		/* Total data set length */
		$iTotal = $this->ClientContactDevice->find('count',array('conditions' => $conditions));

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
}
