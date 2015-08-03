<?php
App::uses('AppController', 'Controller');
/**
 * ClientContacts Controller
 *
 * @property ClientContact $ClientContact
*/
class ClientContactsController extends AppController {

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index($clientid = null) {
		$this->set('clientid',$clientid);
		$this->set('ajaxPlaceholder',$this->getAjaxplaceholder());
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($clientid = null) {
		$role = $this->getUserRole();
		if ($this->request->is('post')) {

			if(empty($this->request->data['ClientContact']['name'])){
				if($role != 'admin'){
					$user = $this->Auth->user();
					$this->set('client_info_id', $user['client_info_id']);
				}else{
					$this->set('client_info_id', $clientid);
				}
				$this->set('chk', $chk?'true':'false');
				$this->set('role', $role);
				$this->set('ajaxPlaceholder',$this->getAjaxplaceholder());
				$this->Session->setFlash(__('Contact Name should not be empty.'), 'flash_fail');
				return;
			}

			if(!empty($this->request->data['ClientContact']['email']) && !filter_var($this->request->data['ClientContact']['email'], FILTER_VALIDATE_EMAIL)){
				if($role != 'admin'){
					$user = $this->Auth->user();
					$this->set('client_info_id', $user['client_info_id']);
				}else{
					$this->set('client_info_id', $clientid);
				}
				$this->set('chk', $chk?'true':'false');
				$this->set('role', $role);
				$this->set('ajaxPlaceholder',$this->getAjaxplaceholder());
				$this->Session->setFlash(__('Invalid Email !!!.'), 'flash_fail');
				return;
			}
			$this->request->data['User']['user_type_id'] = 5;
			$this->request->data['User']['email'] = $this->request->data['ClientContact']['email'];

			$this->ClientContact->User->set($this->request->data);
			$this->ClientContact->set($this->request->data);

			if($this->ClientContact->User->validates() && $this->ClientContact->validates()){

				$this->ClientContact->begin();

				$userid = null;
				$contactid = String::uuid();
				$clientid = $this->request->data['ClientContact']['client_info_id'];
				$userid = String::uuid();
				$this->request->data['User']['id'] = $userid;
				$this->request->data['User']['client_contact_id'] = $contactid;
				$this->request->data['User']['client_info_id'] = $clientid;
				$this->ClientContact->User->create();
				if ($this->ClientContact->User->save($this->request->data)) {
					$this->request->data['ClientContact']['id'] = $contactid;
					$this->request->data['ClientContact']['user_id'] = $userid;
					$this->ClientContact->create();
					if ($this->ClientContact->save($this->request->data)) {
						$this->ClientContact->commit();
						$this->Session->setFlash(__('The client contact has been saved'), 'flash_success');
						$this->redirect(array('action' => 'index',$clientid));
					}
				}
				$this->ClientContact->rollback();
				$this->Session->setFlash(__('The client contact could not be saved. Please, try again.'), 'flash_fail');

			}
			else
			{
				$this->Session->setFlash(__('Please fix the inputs below.'), 'flash_fail');
			}
		}
		if($role != 'admin'){
			$user = $this->Auth->user();
			$this->set('client_info_id', $user['client_info_id']);
		}else{
			$this->set('client_info_id', $clientid);
		}
		$this->set('chk', $chk?'true':'false');
		$this->set('role', $role);
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
		$this->ClientContact->id = $id;
		if (!$this->ClientContact->exists()) {
			throw new NotFoundException(__('Invalid client contact'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$clientid = $this->request->query['clientid'];
			if(empty($clientid)){
				if($this->getUserRole() != 'super' || $this->getUserRole() != 'single'){
					$user = $this->Auth->user();
					$clientid = $user['client_info_id'];
				}
			}
			if ($this->ClientContact->save($this->request->data)) {
				$this->Session->setFlash(__('The client contact has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index',$clientid));
			} else {
				$this->Session->setFlash(__('The client contact could not be saved. Please, try again.'), 'flash_fail');
			}
		}else {
			$this->request->data = $this->ClientContact->read(null, $id);
		}
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
		$clientid = $this->request->query['clientid'];
		$this->ClientContact->id = $id;
		if (!$this->ClientContact->exists()) {
			throw new NotFoundException(__('Invalid client contact'));
		}
		$this->loadModel('User');
		$user = $this->User->findByClientContactId($id);
		$this->User->id = $user['User']['id'];
		$this->User->delete();
		if ($this->ClientContact->delete()) {
			$this->Session->setFlash(__('Client contact deleted'), 'flash_success');
			$this->redirect(array('action' => 'index', $clientid));
		}
		$this->Session->setFlash(__('Client contact was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index', $clientid));
	}

	public function jsondata($id = null){

		//'id','client_info_id','mobile','email','contactby','name',
		$fields = array('ClientContact.id','ClientContact.name','ClientContact.mobile','ClientContact.email');
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
		$and[] = array('ClientContact.client_info_id'=>$id);

		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
			
		$result = $this->ClientContact->find('all',
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
		$iTotal = $this->ClientContact->find('count',array('conditions' => $conditions));

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
