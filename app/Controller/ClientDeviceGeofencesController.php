<?php
App::uses('AppController', 'Controller');
/**
 * ClientDeviceGeofences Controller
 *
 * @property ClientDeviceGeofence $ClientDeviceGeofence
 */
class ClientDeviceGeofencesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
	}

	
	public function get_geo_fences($did=null){
		if($did){
			
			$geofences = $this->ClientDeviceGeofence->find('all',array('fields'=>'Geofence.id, Geofence.name', 'conditions'=>array('ClientDevice.deviceid'=>$did)));
			return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($geofences)));
		}else{
			return new CakeResponse(array('type' => 'application/json', 'body' => json_encode("[]")));
		}
	}
	
	public function save(){
		if ($this->request->is('post')) {
			$did = $this->request->data['did'];
			$gids = json_decode($this->request->data['gids'], true);
			$geofences = $this->ClientDeviceGeofence->find('all',array('fields'=>'Geofence.id', 'conditions'=>array('ClientDeviceGeofence.client_device_id'=>$did)));
			$fences = array();
			foreach ($geofences as &$value) {
    			$fences[] = $value['Geofence']['id'];
			}	
			$contactid = $this->getUserContactid();
			
			$flg = true;
			$this->ClientDeviceGeofence->begin();
			foreach ($gids as &$value) {
    			if(!in_array($value,$fences)){
    				$data['client_contact_id'] = $contactid;
    				$data['client_device_id'] = $did;
    				$data['geofence_id'] = $value;
    				
    				$this->ClientDeviceGeofence->create();
    				if(!$this->ClientDeviceGeofence->save($data)){
    					$flg = false;
    					break;
    				}
    			}
			}
			foreach ($fences as &$value) {
    			if(!in_array($value,$gids)){
					$this->ClientDeviceGeofence->deleteAll(array('ClientDeviceGeofence.client_device_id'=>$did, 'ClientDeviceGeofence.geofence_id'=>$value), false);	
    			}
			}
			if($flg){
				$this->ClientDeviceGeofence->commit();
			}else{
				$this->ClientDeviceGeofence->rollback();
			}
			$this->Session->setFlash(__('The client device geofence has been saved'), 'flash_success');
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => ''));				
		
	}
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view() {

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClientDeviceGeofence->create();
			if ($this->ClientDeviceGeofence->save($this->request->data)) {
				$this->Session->setFlash(__('The client device geofence has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client device geofence could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$clientContacts = $this->ClientDeviceGeofence->ClientContact->find('list');
		$clientDevices = $this->ClientDeviceGeofence->ClientDevice->find('list');
		$geofences = $this->ClientDeviceGeofence->Geofence->find('list');
		$this->set(compact('clientContacts', 'clientDevices', 'geofences'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ClientDeviceGeofence->id = $id;
		if (!$this->ClientDeviceGeofence->exists()) {
			throw new NotFoundException(__('Invalid client device geofence'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClientDeviceGeofence->save($this->request->data)) {
				$this->Session->setFlash(__('The client device geofence has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client device geofence could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ClientDeviceGeofence->read(null, $id);
		}
		$clientContacts = $this->ClientDeviceGeofence->ClientContact->find('list');
		$clientDevices = $this->ClientDeviceGeofence->ClientDevice->find('list');
		$geofences = $this->ClientDeviceGeofence->Geofence->find('list');
		$this->set(compact('clientContacts', 'clientDevices', 'geofences'));
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
		$this->ClientDeviceGeofence->id = $id;
		if (!$this->ClientDeviceGeofence->exists()) {
			throw new NotFoundException(__('Invalid client device geofence'));
		}
		if ($this->ClientDeviceGeofence->delete()) {
			$this->Session->setFlash(__('Client device geofence deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Client device geofence was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){

		$fields = array('ClientDeviceGeofence.field1','ClientDeviceGeofence.field2','...');
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
		 
		$result = $this->ClientDeviceGeofence->find('all',
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
		$iTotal = $this->ClientDeviceGeofence->find('count',array('conditions' => $conditions));

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
