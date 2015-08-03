<?php
App::uses('AppController', 'Controller');
/**
 * ClientExpenses Controller
 *
 * @property ClientExpense $ClientExpense
*/
class ClientExpensesController extends AppController {

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index($deviceid = null) {
		$this->set('deviceid', $deviceid);
	}

	public function get_summary(){
		$role = $this->getUserRole();
		$conditions = array();
		if($role=="group"){
			$contactid = $this->getUserContactid();
			$conditions = array('ClientExpense.client_info_id'=>$contactid);
		}else{
			$clientid = $this->getUserClientid();
			$conditions = array('ClientExpense.client_info_id'=>$clientid);

		}
		$options = 	array(
				'conditions' => $conditions,
				'fields'=>array('ExpenseType.name','SUM(ClientExpense.amount) as `total`'),
				'group' => 'ClientExpense.expense_type_id'
		);
		$result = $this->ClientExpense->find('all', $options);
		return new CakeResponse(array('type' => 'application/json','body' => json_encode($result)));
	}
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->ClientExpense->id = $id;
		if (!$this->ClientExpense->exists()) {
			throw new NotFoundException(__('Invalid client expense'));
		}
		$this->set('clientExpense', $this->ClientExpense->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$cdeviceId = $this->request->data['ClientExpense']['client_device_id'];
			
			$type = $this->request->data['ClientExpense']['expense_type_id'];
			
			$this->loadModel('ClientDevice');
			
			$cd = $this->ClientDevice->find('first', array('conditions'=>array('ClientDevice.deviceid'=>$this->request->data['ClientExpense']['client_device_id']), 'recursive'=> -1));
			
			$this->request->data['ClientExpense']['client_device_id'] = $cd['ClientDevice']['id'];
			
			$deviceid = $this->request->data['ClientExpense']['client_device_id'];
			
			if(!$this->checkExists($type, $deviceid))
			{
				$this->Session->setFlash(__('Duplicate Expense Type.!!!'), 'flash_fail');
				$expenseTypes = $this->ClientExpense->ExpenseType->find('list');
				$this->set('deviceId', $cdeviceId);
				$this->set(compact('expenseTypes'));
				return;
			}
			$this->ClientExpense->create();
			$this->request->data['ClientExpense']['client_info_id'] = $this->getUserClientid();
			$this->request->data['ClientExpense']['client_contact_id'] = $this->getUserContactid();
				
			if ($this->ClientExpense->save($this->request->data)) {
				$this->Session->setFlash(__('The client expense has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index',$cdeviceId));
			} else {
				$this->Session->setFlash(__('The client expense could not be saved. Please, try again.'), 'flash_fail');
				$this->set('deviceId', $cdeviceId);
			}
		}
		$expenseTypes = $this->ClientExpense->ExpenseType->find('list');
		$this->set(compact('expenseTypes'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->ClientExpense->id = $id;
		if (!$this->ClientExpense->exists()) {
			throw new NotFoundException(__('Invalid client expense'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->loadModel('ClientDevice');
			
			$cdeviceId = $this->request->data['ClientExpense']['client_device_id'];
			
			$cd = $this->ClientDevice->find('first', array('conditions'=>array('ClientDevice.deviceid'=>$cdeviceId), 'recursive'=> -1));
			
			$this->request->data['ClientExpense']['client_device_id'] = $cd['ClientDevice']['id'];
			
			$deviceid = $this->request->data['ClientExpense']['client_device_id'];
			
			$type = $this->request->data['ClientExpense']['expense_type_id'];
			
			if(!$this->checkExists($type, $deviceid, $id)){
				$this->Session->setFlash(__('Duplicate Expense Type.!!!'), 'flash_fail');
				$expenseTypes = $this->ClientExpense->ExpenseType->find('list');
				$deviceid = $cdeviceId;
				$this->set(compact('expenseTypes', 'deviceid'));
				return;
			}
						
			if ($this->ClientExpense->save($this->request->data)) {
				$this->Session->setFlash(__('The client expense has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index', $cdeviceId));
			} else {
				$this->Session->setFlash(__('The client expense could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->ClientExpense->read(null, $id);
		}
		$this->loadModel('ClientDevice');
		$cd = $this->ClientDevice->find('first', array('conditions'=>array('ClientDevice.id'=>$this->request->data['ClientExpense']['client_device_id']), 'recursive'=> -1));
		$deviceid = $cd['ClientDevice']['deviceid'];
		$expenseTypes = $this->ClientExpense->ExpenseType->find('list');
		$this->set(compact('expenseTypes', 'deviceid'));
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
		$this->ClientExpense->id = $id;
		if (!$this->ClientExpense->exists()) {
			throw new NotFoundException(__('Invalid client expense'));
		}
		$this->loadModel('ClientDevice');
		$ce = $this->ClientExpense->read(null, $id);
		$cd = $this->ClientDevice->find('first', array('conditions'=>array('ClientDevice.id'=>$ce['ClientExpense']['client_device_id']), 'recursive'=> -1));
		$deviceid = $cd['ClientDevice']['deviceid'];
		if ($this->ClientExpense->delete()) {
			$this->Session->setFlash(__('Client expense deleted'), 'flash_success');
			$this->redirect(array('action' => 'index',$deviceid));
		}
		$this->Session->setFlash(__('Client expense was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function jsondata(){

		$fields = array('ClientExpense.id','ClientInfo.name','ClientDevice.name','ExpenseType.name','ClientExpense.ondate','ClientExpense.amount','ClientExpense.comments');
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
				$orderby[] = 'ClientExpense.modified desc';
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
			
		if(isset($this->request->query['cdeviceid']) && !empty($this->request->query['cdeviceid'])){
			$this->loadModel('ClientDevice');
			$cd = $this->ClientDevice->find('first', array('conditions'=>array('ClientDevice.deviceid'=>$this->request->query['cdeviceid']), 'recursive'=> -1));
			$and[] = array('ClientExpense.client_device_id'=>$cd['ClientDevice']['id']);
		}
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
			
		$result = $this->ClientExpense->find('all',
				array(
						'conditions' => $conditions,
						'recursive' => 0,
						'fields' => $fields,
						'order' => $orderby
				)
		);

		/* Total data set length */
		$iTotal = $this->ClientExpense->find('count',array('conditions' => $conditions));

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

	function checkExists($typeId, $deviceid, $id = null){
		if($id == null){
			$ce = $this->ClientExpense->find('all', array('conditions'=>array('ClientExpense.expense_type_id'=>$typeId, 'ClientExpense.client_device_id'=> $deviceid), 'recursive'=>-1));
			if (empty($ce)) {
				return true;
			}
			else{
				return false;
			}
		}
		else{
			$ce = $this->ClientExpense->find('all', array('conditions'=>array('ClientExpense.expense_type_id'=>$typeId, 'ClientExpense.client_device_id'=> $deviceid, 'ClientExpense.id !='=> $id), 'recursive'=>-1 ));
			pr($this->ClientExpense->getDataSource()->getLog(false));
			if (empty($ce)) {
				return true;
			}
			else{
				return false;
			}
		}
	}
}
