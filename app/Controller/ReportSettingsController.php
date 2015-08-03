<?php
App::uses('AppController', 'Controller');
/**
 * ReportSettings Controller
 *
 * @property ReportSetting $ReportSetting
 */
class ReportSettingsController extends AppController {

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
		$this->ReportSetting->id = $id;
		if (!$this->ReportSetting->exists()) {
			throw new NotFoundException(__('Invalid report setting'));
		}
		$this->set('reportSetting', $this->ReportSetting->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ReportSetting->create();
			$this->request->data['ReportSetting']['name'] = str_replace(' ', '_', $this->request->data['ReportSetting']['human_name']);
			$this->request->data['ReportSetting']['name'] = strtolower($this->request->data['ReportSetting']['name']);
			if ($this->ReportSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The report setting has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The report setting could not be saved. Please, try again.'), 'flash_fail');
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
		$this->ReportSetting->id = $id;
		if (!$this->ReportSetting->exists()) {
			throw new NotFoundException(__('Invalid report setting'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['ReportSetting']['name'] = str_replace(' ', '_', $this->request->data['ReportSetting']['human_name']);
			if ($this->ReportSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The report setting has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The report setting could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ReportSetting->read(null, $id);
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
		$this->ReportSetting->id = $id;
		if (!$this->ReportSetting->exists()) {
			throw new NotFoundException(__('Invalid report setting'));
		}
		if ($this->ReportSetting->delete()) {
			$this->Session->setFlash(__('Report setting deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Report setting was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){
		//<!-- 'id','name','description',  -->
		$fields = array('ReportSetting.id','ReportSetting.human_name','ReportSetting.description');
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
		 
		$result = $this->ReportSetting->find('all',
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
		$iTotal = $this->ReportSetting->find('count',array($conditions));

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
