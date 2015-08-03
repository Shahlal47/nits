<?php
App::uses('AppController', 'Controller');
/**
 * VehicleTypes Controller
 *
 * @property VehicleType $VehicleType
*/
class VehicleTypesController extends AppController {


	public function get_vahicle_defaults($id){
		$this->VehicleType->id = $id;
		if (!$this->VehicleType->exists()) {
			throw new NotFoundException(__('Invalid vehicle type'));
		}
		$vehicleType = $this->VehicleType->read(null, $id);
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($vehicleType)));
	}
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
		$this->VehicleType->id = $id;
		if (!$this->VehicleType->exists()) {
			throw new NotFoundException(__('Invalid vehicle type'));
		}
		$this->set('vehicleType', $this->VehicleType->read(null, $id));

	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->VehicleType->create();
			if ($this->VehicleType->save($this->request->data)) {
				$this->Session->setFlash(__('The vehicle type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle type could not be saved. Please, try again.'), 'flash_fail');
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
		$this->VehicleType->id = $id;
		if (!$this->VehicleType->exists()) {
			throw new NotFoundException(__('Invalid vehicle type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->VehicleType->save($this->request->data)) {
				$this->Session->setFlash(__('The vehicle type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vehicle type could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->VehicleType->read(null, $id);
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
		$this->VehicleType->id = $id;
		if (!$this->VehicleType->exists()) {
			throw new NotFoundException(__('Invalid vehicle type'));
		}
		if ($this->VehicleType->delete()) {
			$this->Session->setFlash(__('Vehicle type deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vehicle type was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function jsondata(){

		$fields = array('VehicleType.id','VehicleType.name','VehicleType.description');
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
				$orderby[] = 'VehicleType.modified desc';
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
			
		$result = $this->VehicleType->find('all',
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
		$iTotal = $this->VehicleType->find('count',array('conditions' => $conditions));

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
