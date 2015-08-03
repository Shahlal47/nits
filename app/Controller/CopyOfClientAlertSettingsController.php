<?php
App::uses('AppController', 'Controller');
/**
 * ClientAlertSettings Controller
 *
 * @property ClientAlertSetting $ClientAlertSetting
 */
class ClientAlertSettingsController extends AppController {

	var $uses = array('ClientAlertSetting','ClientContact','AlertType','ClientDevice');
/**
 * index method
 *
 * @return void
 */
	public function index($id = null) {
		$this->set(compact('id'));
	}

	public function settings($id = null){
		$alert_settings= $this->ClientAlertSetting->find('all',
					array(
									'recursive' => 0,
									'fields' => array(
												'ClientAlertSetting.id',
												'ClientAlertSetting.alert_type_id',
												'AlertType.name',
												'ClientAlertSetting.client_contact_id',
												'ClientContact.name',
												'ClientAlertSetting.client_device_id',
												'ClientDevice.name',
												'ClientAlertSetting.alert_by'
												),
									'conditions' => array('ClientAlertSetting.client_info_id'=>$id),
					)
				);
		$contacts = $this->ClientContact->find('list',
					array(
							'conditions' => array('ClientContact.client_info_id'=>$id),
					)
				);
		$devices = $this->ClientDevice->find('list');
				
		$alert_types = $this->AlertType->find('list');
		$alertBy = array('sms' => 'Sms', 'email' => 'email');
		$this->set(compact('alertBy','alert_settings','contacts','alert_types','id','devices'));
	}
	public function savesettings(){
		/*
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
		
		$this->redirect(array('action' => 'settings',$cid));*/
	}	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ClientAlertSetting->id = $id;
		if (!$this->ClientAlertSetting->exists()) {
			throw new NotFoundException(__('Invalid client alert setting'));
		}
		$this->set('clientAlertSetting', $this->ClientAlertSetting->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//pr($this->request->data);
		$id=$this->request->data['client_info_id'];
		if ($this->request->is('post')) {
			$this->ClientAlertSetting->create();
			if (!$this->ClientAlertSetting->save($this->request->data)) {
				return new CakeResponse(array('body' => "ERROR"));
			}
		}
		$this->redirect(array('action' => 'settings',$id));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit() {
		$id=$this->request->data['client_info_id'];
		if ($this->request->is('post')) {
			if (!$this->ClientAlertSetting->save($this->request->data)) {
				return new CakeResponse(array('body' => "ERROR"));
			}
		}
		$this->redirect(array('action' => 'settings',$id));		
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
		//pr($this->request->data);
		$cid = $this->request->data['cid'];
		$this->ClientAlertSetting->id = $id;
		if (!$this->ClientAlertSetting->exists()) {
			return new CakeResponse(array('body' => "ERROR"));
		}
		if ($this->ClientAlertSetting->delete()) {
			$this->redirect(array('action' => 'settings',$cid));
		}
		return new CakeResponse(array('body' => "ERROR"));
	}
	
	public function jsondata(){
		// <!-- 'id','client_info_id','alert_type_id','client_contact_id',  -->
		$fields = array('ClientAlertSetting.id','ClientContact.name','ClientDevice.name','AlertType.name','ClientAlertSetting.alert_by');
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
		$client_info_id = isset($this->request->query['client_info_id'])?$this->request->query['client_info_id']:null;
		if($client_info_id!=null){
			$and[] = array('ClientAlertSetting.client_info_id'=>$client_info_id);	
		}
		
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
		 
		$result = $this->ClientAlertSetting->find('all',
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
		$iTotal = $this->ClientAlertSetting->find('count',array($conditions));

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
