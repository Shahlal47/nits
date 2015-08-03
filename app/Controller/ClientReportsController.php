<?php
App::uses('AppController', 'Controller');
/**
 * ClientReports Controller
 *
 * @property ClientReport $ClientReport
 */
class ClientReportsController extends AppController {

	var $uses = array('ClientReport','ReportSetting');
	
	
	public function get_reports(){
		$clientid = $this->getUserClientid();
		$client_reports= $this->ClientReport->find('first',
					array(
									'recursive' => -1,
									'fields' => array('ClientReport.reports'),
									'conditions' => array('ClientReport.client_info_id'=>$clientid),
					)
				);				
		$client_reports = explode(",",$client_reports['ClientReport']['reports']);
		
		return $client_reports;				
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
	}

	public function settings($id = null){
		$client_reports= $this->ClientReport->find('first',
					array(
									'recursive' => 0,
									'fields' => array('ClientReport.id','ClientReport.reports'),
									'conditions' => array('ClientReport.client_info_id'=>$id),
					)
				);
		$this->set('id', $client_reports['ClientReport']['id']);
				
		$client_reports = explode(",",$client_reports['ClientReport']['reports']);
		$reports= $this->ReportSetting->find('list');
		
		$this->set('client_reports', $client_reports);		
		$this->set('reports', $reports);		
		$this->set('client_info_id', $id);
	}
	public function savesettings(){
		$id = $this->request->data['ClientReport']['id'];
		$cid = $this->request->data['ClientReport']['client_info_id'];
		if($id){
			if ($this->ClientReport->save($this->request->data)) {
				$this->Session->setFlash(__('The client report has been saved'), 'flash_success');
			} else {
				$this->Session->setFlash(__('The client report could not be saved. Please, try again.'), 'flash_fail');
			}						
		}else{
			$this->ClientReport->create();
			if ($this->ClientReport->save($this->request->data)) {
				$this->Session->setFlash(__('The client report has been saved'), 'flash_success');
			} else {
				$this->Session->setFlash(__('The client report could not be saved. Please, try again.'), 'flash_fail');
			}			
		}
		
		$this->redirect(array('action' => 'settings',$cid));
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ClientReport->id = $id;
		if (!$this->ClientReport->exists()) {
			throw new NotFoundException(__('Invalid client report'));
		}
		$this->set('clientReport', $this->ClientReport->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClientReport->create();
			if ($this->ClientReport->save($this->request->data)) {
				$this->Session->setFlash(__('The client report has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client report could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$clientInfos = $this->ClientReport->ClientInfo->find('list');
		$this->set(compact('clientInfos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ClientReport->id = $id;
		if (!$this->ClientReport->exists()) {
			throw new NotFoundException(__('Invalid client report'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClientReport->save($this->request->data)) {
				$this->Session->setFlash(__('The client report has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client report could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ClientReport->read(null, $id);
		}
		$clientInfos = $this->ClientReport->ClientInfo->find('list');
		$this->set(compact('clientInfos'));
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
		$this->ClientReport->id = $id;
		if (!$this->ClientReport->exists()) {
			throw new NotFoundException(__('Invalid client report'));
		}
		if ($this->ClientReport->delete()) {
			$this->Session->setFlash(__('Client report deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Client report was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){

		$fields = array('ClientReport.field1','ClientReport.field2','...');
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
		 
		$result = $this->ClientReport->find('all',
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
		$iTotal = $this->ClientReport->find('count',array('conditions' => $conditions));

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
