<?php
App::uses('AppController', 'Controller');
/**
 * VehicleModels Controller
 *
 * @property VehicleModel $VehicleModel
*/
class VehicleModelsController extends AppController {

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
		$this->VehicleModel->id = $id;
		if (!$this->VehicleModel->exists()) {
			throw new NotFoundException(__('Invalid vehicle model'));
		}
		$this->set('vehicleModel', $this->VehicleModel->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->VehicleModel->create();
			if ($this->VehicleModel->save($this->request->data)) {
				$this->Session->setFlash(__('The vehicle model has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle model could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$vehicleTypes = $this->VehicleModel->VehicleType->find('list');
		$this->set(compact('vehicleTypes'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->VehicleModel->id = $id;
		if (!$this->VehicleModel->exists()) {
			throw new NotFoundException(__('Invalid vehicle model'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->VehicleModel->save($this->request->data)) {
				$this->Session->setFlash(__('The vehicle model has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle model could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->VehicleModel->read(null, $id);
		}
		$vehicleTypes = $this->VehicleModel->VehicleType->find('list');
		$this->set(compact('vehicleTypes'));
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
		$this->VehicleModel->id = $id;
		if (!$this->VehicleModel->exists()) {
			throw new NotFoundException(__('Invalid vehicle model'));
		}
		if ($this->VehicleModel->delete()) {
			$this->Session->setFlash(__('Vehicle model deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vehicle model was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function jsondata(){

		$fields = array('VehicleModel.id','VehicleType.name','VehicleModel.name', 'VehicleModel.desc');
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
				$orderby[] = 'VehicleModel.modified desc';
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
			
		$result = $this->VehicleModel->find('all',
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
		$iTotal = $this->VehicleModel->find('count',array('conditions' => $conditions));

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
	
	public function getVehicleModelByVehicleType($vehicleTypeId = null){
		$vehicleModels = $this->VehicleModel->find('list',array('conditions'=>array('VehicleModel.vehicle_type_id'=>$vehicleTypeId)));
		return new CakeResponse(array('type'=>'application/json', 'body'=>json_encode($vehicleModels)));
	}
}
