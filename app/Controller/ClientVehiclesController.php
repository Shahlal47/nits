<?php
App::uses('AppController', 'Controller');
/**
 * ClientVehicles Controller
 *
 * @property ClientVehicle $ClientVehicle
 */
class ClientVehiclesController extends AppController {

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
		$this->ClientVehicle->id = $id;
		if (!$this->ClientVehicle->exists()) {
			throw new NotFoundException(__('Invalid client vehicle'));
		}
		$this->set('clientVehicle', $this->ClientVehicle->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClientVehicle->create();
			if ($this->ClientVehicle->save($this->request->data)) {
				$this->Session->setFlash(__('The client vehicle has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client vehicle could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$fuelTypes = $this->ClientVehicle->FuelType->find('list');
		$vehicleTypes = $this->ClientVehicle->VehicleType->find('list');
		$clientInfos = $this->ClientVehicle->ClientInfo->find('list');
		$clientDevices = $this->ClientVehicle->ClientDevice->find('list');
		$this->set(compact('fuelTypes', 'vehicleTypes', 'clientInfos', 'clientDevices'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ClientVehicle->id = $id;
		if (!$this->ClientVehicle->exists()) {
			throw new NotFoundException(__('Invalid client vehicle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClientVehicle->save($this->request->data)) {
				$this->Session->setFlash(__('The client vehicle has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client vehicle could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ClientVehicle->read(null, $id);
		}
		$fuelTypes = $this->ClientVehicle->FuelType->find('list');
		$vehicleTypes = $this->ClientVehicle->VehicleType->find('list');
		$clientInfos = $this->ClientVehicle->ClientInfo->find('list');
		$clientDevices = $this->ClientVehicle->ClientDevice->find('list');
		$this->set(compact('fuelTypes', 'vehicleTypes', 'clientInfos', 'clientDevices'));
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
		$this->ClientVehicle->id = $id;
		if (!$this->ClientVehicle->exists()) {
			throw new NotFoundException(__('Invalid client vehicle'));
		}
		if ($this->ClientVehicle->delete()) {
			$this->Session->setFlash(__('Client vehicle deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Client vehicle was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){

		$fields = array('ClientVehicle.field1','ClientVehicle.field2','...');
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
		 
		$result = $this->ClientVehicle->find('all',
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
		$iTotal = $this->ClientVehicle->find('count',array('conditions' => $conditions));

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
