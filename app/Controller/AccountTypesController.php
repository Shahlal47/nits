<?php
App::uses('AppController', 'Controller');

class AccountTypesController extends AppController {

	public function index() {
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->AccountType->create();
			if ($this->AccountType->save($this->request->data)) {
				$this->Session->setFlash(__('The account type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account type could not be saved. Please, try again.'), 'flash_fail');
			}
		}
	}

	public function edit($id = null) {
		$this->AccountType->id = $id;
		if (!$this->AccountType->exists()) {
			throw new NotFoundException(__('Invalid account type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AccountType->save($this->request->data)) {
				$this->Session->setFlash(__('The account type has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account type could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->AccountType->read(null, $id);
		}
	}

	public function delete($id = null) {
		//if (!$this->request->is('post')) {
		//	throw new MethodNotAllowedException();
		//}
		$this->AccountType->id = $id;
		if (!$this->AccountType->exists()) {
			throw new NotFoundException(__('Invalid account type'));
		}
		if ($this->AccountType->delete()) {
			$this->Session->setFlash(__('Account type deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Account type was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function jsondata(){
		//<!-- 'id','name','description',  -->
		$fields = array('AccountType.id','AccountType.name','AccountType.months','AccountType.description');
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
				$orderby[] = 'AccountType.modified desc';
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
			
		$result = $this->AccountType->find('all',
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
		$iTotal = $this->AccountType->find('count',array('conditions' => $conditions));

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
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($output)));
	}
}
