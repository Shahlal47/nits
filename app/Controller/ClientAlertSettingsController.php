<?php
App::uses('AppController', 'Controller');
/**
 * ClientAlertSettings Controller
 *
 * @property ClientAlertSetting $ClientAlertSetting
 */
class ClientAlertSettingsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index($id = null) {
		$this->set(compact('id'));
		$this->set('ajaxPlaceholder',$this->getAjaxplaceholder());
	}



/**
 * add method
 *
 * @return void
 */
	public function add($id = null) {
		if ($this->request->is('post')) {
			$clientid = $this->request->data['ClientAlertSetting']['client_info_id'];
			$this->ClientAlertSetting->create();
			if ($this->ClientAlertSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The client alert setting has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index',$clientid));
			} else {
				$this->Session->setFlash(__('The client alert setting could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$clientinfo = $this->ClientAlertSetting->ClientInfo->read(null, $id);
		if($clientinfo['ClientInfo']['client_type_id']==1){
			$clientDevices = $this->ClientAlertSetting->ClientDevice->find('list',array('conditions'=>array('ClientDevice.client_info_id'=>$id)));
			$this->set(compact('clientDevices'));
			
		}
		
		$alertTypes = $this->ClientAlertSetting->AlertType->find('list');
		$clientContacts = $this->ClientAlertSetting->ClientContact->find('list',array('conditions'=>array('ClientContact.client_info_id'=>$id)));
		$clientDevices = $this->ClientAlertSetting->ClientDevice->find('list',array('conditions'=>array('ClientDevice.client_info_id'=>$id)));
		$this->set(compact('alertTypes', 'clientContacts'));
				
		$this->set('client_info_id', $id);
		$this->set('client_type_id', $clientinfo['ClientInfo']['client_type_id']);
		$this->set('ajaxPlaceholder',$this->getAjaxplaceholder());
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ClientAlertSetting->id = $id;
		
		if (!$this->ClientAlertSetting->exists()) {
			throw new NotFoundException(__('Invalid client alert setting'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$clientid = $this->request->data['ClientAlertSetting']['client_info_id'];
			if ($this->ClientAlertSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The client alert setting has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index',$clientid));
			} else {
				$this->Session->setFlash(__('The client alert setting could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ClientAlertSetting->read(null, $id);
		}
		$this->set('client_info_id', $clientid);
		$this->set('ajaxPlaceholder',$this->getAjaxplaceholder());
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
		$this->ClientAlertSetting->id = $id;
		if (!$this->ClientAlertSetting->exists()) {
			throw new NotFoundException(__('Invalid client alert setting'));
		}
		$clientid = $this->request->query['clientid'];
		if ($this->ClientAlertSetting->delete()) {
			$this->Session->setFlash(__('Client alert setting deleted'), 'flash_success');
			$this->redirect(array('action' => 'index',$clientid));
		}
		$this->Session->setFlash(__('Client alert setting was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){

		$fields = array('ClientAlertSetting.id','ClientDevice.name','ClientContact.name','AlertType.name','ClientAlertSetting.is_sms','ClientAlertSetting.is_email');
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
		$iTotal = $this->ClientAlertSetting->find('count',array('conditions' => $conditions));

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
