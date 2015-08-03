<?php
App::uses('AppController', 'Controller');
/**
 * Geofences Controller
 *
 * @property Geofence $Geofence
 */
class GeofencesController extends AppController {

	var $uses = array('GeofenceType','Geofence');
/**
 * index method
 *
 * @return void
 */
	public function index() {
	}
	public function get_geo_fences(){
		$clientid = $this->getUserClientid(); //array(
		$geofences = $this->Geofence->find('all',array('fields'=>'Geofence.id, Geofence.name','conditions'=>array('Geofence.client_info_id'=>$clientid)));
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($geofences)));
	}
	public function get_geo_fence_info($id=null){
		$this->Geofence->id = $id;
		if (!$this->Geofence->exists()) {
			throw new NotFoundException(__('Invalid Geo-Fence id'));
		}
		$geofence = $this->Geofence->read(null, $id);
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($geofence)));				
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view() {
				
		$geofenceTypes = $this->GeofenceType->find('list');
		
		$this->set(compact('geofenceTypes'));
	}

/**
 * add method
 *
 * @return void
 */
	public function save() {
		if ($this->request->is('post')) {
			if(isset($this->request->data['id']) || empty($this->request->data['id'])){
				$this->Geofence->create();
			}			
			$this->request->data['client_info_id'] = $this->getUserClientid();
			$this->request->data['client_contact_id'] = $this->getUserContactid();
			if ($this->Geofence->save($this->request->data)) {
				//$this->Session->setFlash(__('The geofence has been saved'), 'flash_success');
				$this->redirect(array('action' => 'get_geo_fence_info',$this->Geofence->id));
			} else {
				//$this->Session->setFlash(__('The geofence could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => ''));				
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Geofence->id = $id;
		if (!$this->Geofence->exists()) {
			throw new NotFoundException(__('Invalid geofence'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Geofence->save($this->request->data)) {
				$this->Session->setFlash(__('The geofence has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The geofence could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->Geofence->read(null, $id);
		}
		$clientDevices = $this->Geofence->ClientDevice->find('list');
		$geofenceTypes = $this->Geofence->GeofenceType->find('list');
		$clientDevices = $this->Geofence->ClientDevice->find('list');
		$this->set(compact('clientDevices', 'geofenceTypes', 'clientDevices'));
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
		$this->Geofence->id = $id;
		if (!$this->Geofence->exists()) {
			throw new NotFoundException(__('Invalid geofence'));
		}
		if ($this->Geofence->delete()) {
			return new CakeResponse(array( 'body' => 'OK'));	
		}
		return new CakeResponse(array( 'body' => 'ERROR'));
	}
	
	public function jsondata(){

		$fields = array('Geofence.field1','Geofence.field2','...');
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
		 
		$result = $this->Geofence->find('all',
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
		$iTotal = $this->Geofence->find('count',array('conditions' => $conditions));

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
