<?php
App::uses('AppController', 'Controller');
/**
 * PoiTypes Controller
 *
 * @property PoiType $PoiType
 */
class PoiTypesController extends AppController {

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
		$this->PoiType->id = $id;
		if (!$this->PoiType->exists()) {
			throw new NotFoundException(__('Invalid poi type'));
		}
		$this->set('poiType', $this->PoiType->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PoiType->create();
			if ($this->PoiType->save($this->request->data)) {
				$this->Session->setFlash(__('The poi type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The poi type could not be saved. Please, try again.'), 'flash_fail');
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
		$this->PoiType->id = $id;
		if (!$this->PoiType->exists()) {
			throw new NotFoundException(__('Invalid poi type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PoiType->save($this->request->data)) {
				$this->Session->setFlash(__('The poi type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The poi type could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->PoiType->read(null, $id);
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
		$this->PoiType->id = $id;
		if (!$this->PoiType->exists()) {
			throw new NotFoundException(__('Invalid poi type'));
		}
		if ($this->PoiType->delete()) {
			$this->Session->setFlash(__('Poi type deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Poi type was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function getjson(){
		$result = $this->PoiType->find('all',
		array(
									'recursive' => 0,
									'fields' => array('PoiType.id','PoiType.name','PoiType.marker'),
									'order' => array('PoiType.name')
		)
		);
		return new CakeResponse(array('body' => json_encode($result)));
	}
	public function jsondata(){

		$fields = array('PoiType.id','PoiType.name','PoiType.marker');
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
			
		$result = $this->PoiType->find('all',
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
		$iTotal = $this->PoiType->find('count',array($conditions));

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
