<?php
App::uses('AppController', 'Controller');
/**
 * GeofenceTypes Controller
 *
 * @property GeofenceType $GeofenceType
 */
class GeofenceTypesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->GeofenceType->id = $id;
		if (!$this->GeofenceType->exists()) {
			throw new NotFoundException(__('Invalid geofence type'));
		}
		$this->set('geofenceType', $this->GeofenceType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->GeofenceType->create();
			if ($this->GeofenceType->save($this->request->data)) {
				$this->Session->setFlash(__('The geofence type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The geofence type could not be saved. Please, try again.'), 'flash_fail');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->GeofenceType->id = $id;
		if (!$this->GeofenceType->exists()) {
			throw new NotFoundException(__('Invalid geofence type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->GeofenceType->save($this->request->data)) {
				$this->Session->setFlash(__('The geofence type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The geofence type could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->GeofenceType->read(null, $id);
		}
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
		$this->GeofenceType->id = $id;
		if (!$this->GeofenceType->exists()) {
			throw new NotFoundException(__('Invalid geofence type'));
		}
		if ($this->GeofenceType->delete()) {
			$this->Session->setFlash(__('Geofence type deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Geofence type was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){

		$fields = array('GeofenceType.id','GeofenceType.name','GeofenceType.description');
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
				$orderby[] = 'GeofenceType.modified desc';
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
					
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
		 
		$result = $this->GeofenceType->find('all',
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
		$iTotal = $this->GeofenceType->find('count',array('conditions' => $conditions));

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
