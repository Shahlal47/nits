<?php
App::uses('AppController', 'Controller');
/**
 * DeviceInfos Controller
 *
 * @property DeviceInfo $DeviceInfo
 */
class DeviceInfosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function getDeviceInfos($devicetypeid = null) {
		$devices = $this->DeviceInfo->find('list',array('conditions' => array('device_type_id'=>$devicetypeid)));
		return new CakeResponse(array('body' => json_encode($devices)));
	}
	public function index($id = null) {
		$device_type = $this->DeviceInfo->DeviceType->find('first',array('conditions' => array('id'=>$id)));
		$this->set('device_type',$device_type['DeviceType']);
	}
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->DeviceInfo->id = $id;
		if (!$this->DeviceInfo->exists()) {
			throw new NotFoundException(__('Invalid device info'));
		}
		$this->set('deviceInfo', $this->DeviceInfo->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($deviceid = null) {
		if ($this->request->is('post')) {
			$deviceid = $this->request->data['DeviceInfo']['device_type_id'];
			$this->DeviceInfo->create();
			if ($this->DeviceInfo->save($this->request->data)) {
				$this->Session->setFlash(__('The device info has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index',$deviceid));
			} else {
				$this->Session->setFlash(__('The device info could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$device_type = $this->DeviceInfo->DeviceType->find('first',array('conditions' => array('id'=>$deviceid)));
		$this->set('device_type',$device_type['DeviceType']);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->DeviceInfo->id = $id;
		if (!$this->DeviceInfo->exists()) {
			throw new NotFoundException(__('Invalid device info'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$deviceid = $this->request->data['DeviceInfo']['device_type_id'];
			if ($this->DeviceInfo->save($this->request->data)) {				
				$this->Session->setFlash(__('The device info has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index', $deviceid));
			} else {
				$this->Session->setFlash(__('The device info could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->DeviceInfo->read(null, $id);
		}
		$deviceid = $this->request->data['DeviceInfo']['device_type_id'];		
		$device_type = $this->DeviceInfo->DeviceType->find('first',array('conditions' => array('id'=>$deviceid)));
		$this->set('device_type',$device_type['DeviceType']);
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
		$this->DeviceInfo->id = $id;
		if (!$this->DeviceInfo->exists()) {
			throw new NotFoundException(__('Invalid device info'));
		}
		if ($this->DeviceInfo->delete()) {
			$this->Session->setFlash(__('Device info deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Device info was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}
	
	public function jsondata(){
		// <!-- 'id','name','description','device_type_id','brand',  -->
		$fields = array('DeviceInfo.id','DeviceInfo.name','DeviceInfo.brand','DeviceInfo.description','DeviceType.name');
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
		$deviceid = isset($this->request->query['deviceid'])?$this->request->query['deviceid']:null;
		if($deviceid!=null){
			$and[] = array('device_type_id'=>$deviceid);	
		}
		
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
		 
		$result = $this->DeviceInfo->find('all',
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
		$iTotal = $this->DeviceInfo->find('count',array('conditions' => $conditions));

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
