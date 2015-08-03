<?php
App::uses('AppController', 'Controller');
/**
 * ExtHistories Controller
 *
 * @property ExtHistory $ExtHistory
 */
class ExtHistoriesController extends AppController {
	
	var $uses = array('ClientDeviceSubscription','ExtHistory','ClientDevice'); 

/**
 * index method
 *
 * @return void
 */
	public function index($sid=null) {
		$this->set('cdsid', $sid);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ExtHistory->id = $id;
		if (!$this->ExtHistory->exists()) {
			throw new NotFoundException(__('Invalid ext history'));
		}
		$this->set('extHistory', $this->ExtHistory->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		if ($this->request->is('post')) 
		{
			$data = $this->unserializeForm($this->request->data['form_data']);
			$memo = $data['data%5BExtHistory%5D%5Bmemo_number%5D'];
			$ref = $data['data%5BExtHistory%5D%5Bref_number%5D'];
			$newDate = $data['data%5BExtHistory%5D%5Bto_date%5D'];
			
			$this->ExtHistory->create();
			$this->request->data['ExtHistory']['memo_number'] = $memo;
			$this->request->data['ExtHistory']['ref_number'] = $ref;
			$this->request->data['ExtHistory']['to_date'] = $newDate;
			$this->request->data['ExtHistory']['from_date'] = $this->request->data['e_date'];
			$this->request->data['ExtHistory']['client_device_subscriptions_id'] = $this->request->data['sId'];
			
			$this->ClientDeviceSubscription->id = $this->request->data['sId'];
			$this->ClientDeviceSubscription->saveField('expire_date', $newDate);
			
			if ($this->ExtHistory->save($this->request->data)) 
			{
				$isSuccess = 1;
				return new CakeResponse(array('body' => json_encode($isSuccess), 'type'=>'application/json'));
			} 
			else {
				$this->Session->setFlash(__('The ext history could not be saved. Please, try again.'), 'flash_fail');
			}
		}
	}
	
	/**
	 * 
	 * @param unknown $str
	 * @return multitype:Ambigous <>
	 */
	
	public function batchUpdate()
	{
		if ($this->request->is('post'))
		{
			$data = $this->unserializeForm($this->request->data['form_data']);
			$memo = $data['data%5BExtHistory%5D%5Bmemo_number%5D'];
			$ref = $data['data%5BExtHistory%5D%5Bref_number%5D'];
			$newDate = $data['data%5BExtHistory%5D%5Bto_date%5D'];
			
			$selectedDevices = $this->request->data['trackerIds'];
			
			$histories = array();
			
			$subscriptionIds = array();
			
			foreach($selectedDevices as $device)
			{
				$clientSubscriptions = $this->ClientDeviceSubscription->find('first', array('conditions'=>array('client_deviceid'=>$device),'recursive'=>-1));
				
				$this->ExtHistory->create();
				$history['memo_number'] = $memo;
				$history['ref_number'] = $ref;
				$history['to_date'] = $newDate;
				$history['from_date'] = $clientSubscriptions['ClientDeviceSubscription']['expire_date'];
				$history['client_device_subscriptions_id'] = $clientSubscriptions['ClientDeviceSubscription']['id'];
				$histories[] = $history;
				
				$subscriptionIds[] = $clientSubscriptions['ClientDeviceSubscription']['id'];
				
			}
				
			if ($this->ExtHistory->saveAll($histories))
			{
				$this->ClientDeviceSubscription->updateAll(
						array('ClientDeviceSubscription.expire_date' => $newDate),
						array('ClientDeviceSubscription.id' => $subscriptionIds)
				);
				$this->Session->setFlash(__('Successfully Updated.'), 'flash_success');
				$this->redirect(array('action'=>'dashboard', 'controller'=>'dashboard'));
			}
			else {
				$this->Session->setFlash(__('The ext history could not be saved. Please, try again.'), 'flash_fail');
				$this->redirect(array('action'=>'dashboard', 'controller'=>'dashboard'));
			}
		}
	}
	
	private function unserializeForm($str) {
		$returndata = array();
		$strArray = explode("&", $str);
		$i = 0;
		foreach ($strArray as $item) {
			$array = explode("=", $item);
			$returndata[$array[0]] = $array[1];
		}
	
		return $returndata;
	}
	
	private function fixedEncodeURI($str) {
		return encodeURI(str).replace('/%5B/g', '[').replace('/%5D/g', ']');
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ExtHistory->id = $id;
		if (!$this->ExtHistory->exists()) {
			throw new NotFoundException(__('Invalid ext history'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ExtHistory->save($this->request->data)) {
				$this->Session->setFlash(__('The ext history has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ext history could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ExtHistory->read(null, $id);
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
		$this->ExtHistory->id = $id;
		if (!$this->ExtHistory->exists()) {
			throw new NotFoundException(__('Invalid ext history'));
		}
		if ($this->ExtHistory->delete()) {
			$this->Session->setFlash(__('Ext history deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ext history was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata($cdsid=null){

		$fields = array('ExtHistory.id','ExtHistory.memo_number', 'ExtHistory.ref_number','ExtHistory.from_date','ExtHistory.to_date', 'ExtHistory.created');
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

		$orderby[] = array('ExtHistory.id DESC');
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

		$and[] = array('ExtHistory.client_device_subscriptions_id'=>$cdsid);
		
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
		 
		$result = $this->ExtHistory->find('all',
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
		$iTotal = $this->ExtHistory->find('count',array('conditions' => $conditions));

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
	
	public function get_user_devices_status_list_json()
	{
		
		$userId = $this->request->query['username'];
		
		$query = "select cd.id, cd.deviceid, cd.tracker_id, cd.name
		from client_devices as cd
		left join users on users.client_info_id = cd.client_info_id
		where users.username = '$userId'";
		
		$result = $this->ClientDevice->query($query);
		
		$iTotal = count($result);
		$returndata = array(
					"sEcho" => intval($this->request->query['sEcho']),
					"iTotalRecords" => $iTotal,
					"iTotalDisplayRecords" => $iTotal,
					"aaData" => array()
					);
		
		foreach ($result as $r) {
			$row = array();
			$row[] = $r['cd']['id'];
			$row[] = $r['cd']['deviceid'];
			$row[] = $r['cd']['tracker_id'];
			$row[] = $r['cd']['name'];
			$row[] = "";
			$row[] = "";
			$returndata['aaData'][] = $row;
		}
		return new CakeResponse(array('body' => json_encode($returndata)));
	}
}
