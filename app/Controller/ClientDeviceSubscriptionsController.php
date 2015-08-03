<?php
App::uses('AppController', 'Controller');
/**
 * ClientDeviceSubscriptions Controller
 *
 * @property ClientDeviceSubscription $ClientDeviceSubscription
*/
class ClientDeviceSubscriptionsController extends AppController {

	var $uses = array('ClientDevice','ClientDeviceSubscription','AccountType');


	private function _addMonthsToDate($date, $months){
		$newdate =  date( "Y-m-d", strtotime( $date." +".$months." month" ) );
		return $newdate;
	}
	private function _getExpireDate($activation_date, $account_type_id){
		$accountType = $this->AccountType->find('first',array('fields'=>array('AccountType.months'),'conditions'=>array('AccountType.id'=>$account_type_id)));
		$expire_date = $this->_addMonthsToDate($activation_date, $accountType['AccountType']['months']);
		return 	$expire_date;
	}
	public function getExpireDateJson(){
		$activation_date = $this->request->data['ad'];
		$account_type_id = $this->request->data['at'];
		$expire_date = $this->_getExpireDate($activation_date,$account_type_id);
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($expire_date)));
	}
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index($did=null) {
		$this->set('did',$did);
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->ClientDeviceSubscription->id = $id;
		if (!$this->ClientDeviceSubscription->exists()) {
			throw new NotFoundException(__('Invalid client device subscription'));
		}
		$this->set('clientDeviceSubscription', $this->ClientDeviceSubscription->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($did=null) {
		if ($this->request->is('post')) {
			// find client device info
			$this->ClientDeviceSubscription->begin();
			$device = $this->ClientDevice->find('first',array('fields'=>'ClientDevice.*', 'conditions'=>array('deviceid'=>$this->request->data['ClientDeviceSubscription']['client_deviceid'])));
			//pr($device);
			$this->request->data['ClientDeviceSubscription']['client_info_id'] = $device['ClientDevice']['client_info_id'];
			$this->ClientDeviceSubscription->create();
			if ($this->ClientDeviceSubscription->save($this->request->data)) {
				$device['ClientDevice']['client_device_subscription_id'] = $this->ClientDeviceSubscription->id;

				if ($this->ClientDevice->save($device['ClientDevice'])) {
					pr($device);
					$this->ClientDeviceSubscription->commit();
					$this->Session->setFlash(__('The client device subscription has been saved'), 'flash_success');
					//$this->redirect(array('controller'=>'clientDevices', 'action' => 'index', $device['ClientDevice']['client_info_id']));
					$this->redirect(array('action' => 'index',$this->request->data['ClientDeviceSubscription']['client_deviceid']));
				}
			} else {
				$this->Session->setFlash(__('The client device subscription could not be saved. Please, try again.'), 'flash_fail');
			}
			$this->ClientDeviceSubscription->rollback();
		}
		$accountTypes = $this->ClientDevice->ClientDeviceSubscription->AccountType->find('list');
		
		$history = $this->ClientDeviceSubscription->find('first', array('conditions'=>array('ClientDeviceSubscription.client_deviceid'=>$did), 'order'=>'ClientDeviceSubscription.subscribe_date desc'));
		if(empty($history)){
			$this->set('sDate', date('yyyy-mm-dd'));
		}
		else{
			$this->set('sDate', $history['ClientDeviceSubscription']['expire_date']);
		}
		$this->set(compact('accountTypes'));
		$this->set('did',$did);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->ClientDeviceSubscription->id = $id;
		if (!$this->ClientDeviceSubscription->exists()) {
			throw new NotFoundException(__('Invalid client device subscription'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClientDeviceSubscription->save($this->request->data)) {
				$this->Session->setFlash(__('The client device subscription has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client device subscription could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ClientDeviceSubscription->read(null, $id);
		}
		$clientInfos = $this->ClientDeviceSubscription->ClientInfo->find('list');
		$clientDevices = $this->ClientDeviceSubscription->ClientDevice->find('list');
		$this->set(compact('clientInfos', 'clientDevices'));
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
		$this->ClientDeviceSubscription->id = $id;
		if (!$this->ClientDeviceSubscription->exists()) {
			throw new NotFoundException(__('Invalid client device subscription'));
		}
		if ($this->ClientDeviceSubscription->delete()) {
			$this->Session->setFlash(__('Client device subscription deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Client device subscription was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function jsondata(){
		// <!-- 'id','client_info_id','client_device_id','','','active',  -->
		$fields = array('ClientDeviceSubscription.id','AccountType.name','ClientDeviceSubscription.subscribe_date','ClientDeviceSubscription.expire_date');
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
				$orderby[] = 'ClientDeviceSubscription.modified desc';
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
		$did = isset($this->request->query['did']) ? $this->request->query['did']:null;
		if($did!=null){
			$and[] = array('ClientDeviceSubscription.client_deviceid'=>$did);
		}

		$and[] = array('1'=>1);
		//
			
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
			
		$result = $this->ClientDeviceSubscription->find('all',
				array(
						'conditions' => $conditions,
						'recursive' => 0,
						'fields' => $fields,
						'order' => $orderby,
						'limit' => $limit,
						'offset' => $offset,
				)
		);
		
		//$log = $this->ClientDeviceSubscription->getDataSource()->getLog(false);
		//pr($log);

		/* Total data set length */
		$iTotal = $this->ClientDeviceSubscription->find('count',array('conditions' => $conditions));

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
