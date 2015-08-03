<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
*/
class UsersController extends AppController {
	var $uses = array('User','UserLog');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('reset_password','ajax_login', 'register', 'logout','change_password','remember_password','remember_password_step_2');
	}


	public function search($word=null){
		$word = $this->request->data['query'];
		$dbc = $this->_getConnection('database');
		$rows = array();
		if($dbc!=null){
			$query = "
			SELECT  CONCAT(`id`) AS 'id', CONCAT(`username`) AS 'name' FROM users WHERE `username` LIKE '$word%' and `user_type_id` != 1 LIMIT 0, 10
			";
			$results = $dbc->query($query);

			if(count($results)>0){
				while ($row = $results->fetch_assoc())
				{
					$rows[] = $row;
				}
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($rows)));
	}

	function ajax_check_username($username = null) {
		$v = array('inuse'=>false);
		if (!empty($username)) {
			$u = $this->User->findByUsername($username);
			if (empty($u)) {
				$v = array('inuse'=>true);
			}
		}
		return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($v)));
	}
	public function get_user_session(){
		$userid = $this->Auth->user();
		$userid = $userid['id'];
		$user = $this->User->find('first', array('conditions'=>array('User.id'=>$userid)));
		return $user;
	}

	public function home()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function login()
	{
		if ($this->request->is('post'))
		{
			$user = $this->User->findByUsername($this->request->data['User']['username']);
			if(!empty($user) && $user['User']['active'] == 0){
				$this->Session->setFlash(__('User has been blocked.Please contact with admin. !!!'),'flash_fail');
				return;
			}

			if ($this->Auth->login())
			{
				$user = $this->Auth->user();
				$this->_loguser($user);
				$this->redirect($this->Auth->redirect());
			}
			else
			{
				$this->Session->setFlash(__('Invalid username or password, try again'),'flash_fail');
			}
		}
	}
	private function _loguser($user=null){
		if($user){
			$data['user_id'] = $user['id'];
			$data['user_type_id'] = $user['user_type_id'];
			$this->UserLog->create();
			if ($this->UserLog->save($data)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function ajax_login()
	{
		$arr = array('login' => false);
		if ($this->request->is('post') && $this->Auth->login())
		{
			$arr = array('login' => true);
		}
		return new CakeResponse(array('body' => json_encode($arr)));
	}


	public function logout()
	{
		$this->redirect($this->Auth->logout());
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index($role = null) {
		$this->set('role', $role);
	}

	public function blocked_users() {
	}

	public function client_users($client_info_id=null) {
		$this->set('client_info_id', $client_info_id);
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['User']['user_type_id'] = $this->request->data['User']['role'];
			$this->request->data['User']['active'] = 1;
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'flash_success');
				if($this->request->data['User']['role'] == 6){
					$this->redirect(array('action' => 'index/Accounts'));
				}
				if($this->request->data['User']['role'] == 2){
					$this->redirect(array('action' => 'index/CallCenter'));
				}
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$roles = array('2'=> 'CallCenter', '6'=> 'Accounts');
		$this->set(compact('roles'));
	}

	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['User']['user_type_id'] = $this->request->data['User']['role'];
			$this->request->data['User']['active'] = 1;
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'flash_success');
				if($this->request->data['User']['role'] == 6){
					$this->redirect(array('action' => 'index/Accounts'));
				}
				if($this->request->data['User']['role'] == 2){
					$this->redirect(array('action' => 'index/CallCenter'));
				}
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_fail');
			}
		}
		$this->request->data = $this->User->read(null, $id);
		$roles = array('2'=> 'CallCenter', '6'=> 'Accounts');
		$this->set(compact('roles'));
	}
	public function add_client() {
		if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['User']['user_type_id'] = $this->request->data['User']['role'];
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_fail');
			}
		}
	}

	public function edit_client($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->request->data['User']['user_type_id'] = $this->request->data['User']['role'];
				$this->Session->setFlash(__('The user has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->read(null, $id);
		$role = $user['User']['user_type_id'];
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), 'flash_success');
			if($role == 6){
				$this->redirect(array('action' => 'index/Accounts'));
			}
			if($role == 2){
				$this->redirect(array('action' => 'index/CallCenter'));
			}
		}
		$this->Session->setFlash(__('User was not deleted'), 'flash_fail');
		$this->redirect(array('action' => 'index'));
	}

	public function jsondata(){

		$fields = array('User.id','User.username','UserType.name','User.email','User.block_type', 'User.active');
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
				$orderby[] = 'User.modified desc';
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
		$role = isset($this->request->query['role']) ? $this->request->query['role']:null;
		if($role!=null){
			$and[] = array('UserType.name'=>$role);
		}

		$active = isset($this->request->query['active'])?$this->request->query['active']:null;
		if($active!=null)
		{
			$and[] = array('User.active'=>$active);
		}
		else{
			$and[] = array('User.active'=>1);
		}
		$client_info_id = isset($this->request->query['client_info_id'])?$this->request->query['client_info_id']:null;
		if($client_info_id!=null){
			$and[] = array('User.client_info_id'=>$client_info_id);
		}


		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
			
		$result = $this->User->find('all',
				array(
						'conditions' => $conditions,
						'recursive' => 0,
						'fields' => $fields,
						'order' => $orderby,
						'limit' => $limit,
						'offset' => $offset,
				)
		);
		/* Data set length after filtering */
		// 		$sQuery = " SELECT FOUND_ROWS() rows ";
		// 		$rResultFilterTotal = $this->User->query($sQuery);
		// 		$iFilteredTotal = $rResultFilterTotal[0][0]['rows'];

		/* Total data set length */
		$iTotal = $this->User->find('count',array('conditions' => $conditions));

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



	public function empty_page(){
	}

	public function ad_reset_password()
	{
		if( !empty($this->request->data['User']['id']) )
		{
			# Verify if password matches
			if( $this->request->data['User']['password'] === $this->request->data['User']['re_password'] )
			{
				if(isset($this->request->data['User']['id']) && !empty($this->request->data['User']['id'])){
					if( $this->User->save( $this->request->data ) )
					{
						$this->Session->setFlash('Password updated successfully!','flash_success');
						$this->redirect(array('controller' => 'users', 'action' => 'empty_page'));
					}
				}
				else{
					$this->Session->setFlash('User not found.','flash_fail');
				}
			}
			else
			{
				$this->Session->setFlash('Passwords do not match.','flash_fail');
			}
		}
	}

	public function change_password()
	{
		$user = $this->User->read(null,AuthComponent::user('id'));
		$this->set('user', $user);

		if( $this->request->is('post') )
		{
			# Verify if password matches
			if( $this->request->data['User']['password'] === $this->request->data['User']['re_password'] )
			{
				# Verify if user is logged in
				if( AuthComponent::user('id') )
				{
					$this->request->data['User']['id'] = AuthComponent::user('id');
				}
				else # Maybe hes comming from change password form
				{
					# Check the hash in database
					$user = $this->User->findByHashChangePassword( $this->request->data['User']['hash'] );

					if( !empty($user) )
					{
						$this->request->data['User']['id'] = $user['User']['id'];

						# Clean users hash in database
						$this->request->data['User']['hash_change_password'] = '';
					}
					else
					{
						throw new MethodNotAllowedException(__('Invalid action'));
					}
				}

				if( $this->User->save( $this->request->data ) )
				{
					$this->Session->setFlash('Password updated successfully!','flash_success');
					$this->redirect(array('controller' => 'users', 'action' => 'empty_page'));
				}
			}
			else
			{
				$this->Session->setFlash('Passwords do not match.','flash_fail');
			}
		}
	}


	/**
	 * Email form to inform the process of remembering the password.
	 * After entering the email is checked if this email is valid and if so, a message is sent containing a link to change your password
	 */
	public function remember_password()
	{
		if( $this->request->is('post') )
		{
			$user = $this->User->findByEmail( $this->request->data['User']['email'] );

			if( empty($user) )
			{
				$this->Session->setFlash('This email does not exist in our database.','flash_fail');
				$this->redirect(array('action' => 'login'));
			}

			$hash = $this->User->generateHashChangePassword();

			$data = array(
					'User' => array(
							'id' => $user['User']['id'],
							'hash_change_password' => $hash
					)
			);

			$this->User->save($data);

			$email = new CakeEmail();
			$email->template('remember_password', 'default')
			->config('gmail')
			->emailFormat('html')
			->subject(__('Remember password - '.Configure::read('Application.name')))
			->to( $user['User']['email'] )
			->from( Configure::read('Application.from_email') )
			->viewVars(array('hash' => $hash))
			->send();

			$this->Session->setFlash('Check your e-mail to continue the process of recovering password.','flash_success');

		}
	}

	/**
	 * Step 2 to change the password.
	 * This step verifies that the hash is valid, if it is, show the form to the user to inform your new password
	 */
	public function remember_password_step_2( $hash = null )
	{

		$user = $this->User->findByHashChangePassword( $hash );

		if( $user['User']['hash_change_password'] != $hash || empty($user))
		{
			throw new NotFoundException(__('Link inválido'));
		}

		# Sends the hash to the form to check before changing the password
		$this->set('hash',$hash);

		$this->render('/Users/change_password');

	}


	function sendemail(){
		//pr($this->request->data);
		$from = $this->request->data['email'];
		$name = $this->request->data['name'];
		$subject = $this->request->data['subject'];
		$message = $this->request->data['message'];
		$body = 'From: <b>' . $from . '</b><br/>' ;
		$body .= 'Name: <b>' . $name . '</b><br/>' ;
		$body .= 'Subject: <b>' . $subject . '</b><br/>' ;
		$body .= 'Message: <p>' . $message . '</p>';
		//echo($body);
		//return;
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('smtp');
		$email->from('webcontact@mail.eertbd.com');
		//$email->to = "my_test_mail@centrum.cz <my_test_mail@centrum.cz>";
		$email->to('info@eertbd.com');
		$email->subject('Mail From EERT Website by: '.$from);
		$email->send($body);
		$this->redirect(array('controller' => 'page','action' => 'contact'));
	}

	public function reset_password()
	{
		if ($this->request->is('post'))
		{
			if(isset($this->request->data['User']['email']) && !empty($this->request->data['User']['email']))
			{
				$user = $this->User->findByEmail($this->request->data['User']['email']);
				if (!empty($user))
				{
					$pass = $this->_generateRandomString();
					$user['User']['password'] = $pass;
					if( $this->User->save( $user ) )
					{
						$this->_sendResetedPassword($user['User']['email'],$user['User']['username'],$pass);
						$this->Session->setFlash('Password updated successfully! Check given email for further process.','flash_success');
						$this->redirect(array('controller' => 'users', 'action' => 'login'));
					}
				}
			}
		}
	}

	function _sendResetedPassword($receiver,$name,$pass)
	{
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('gmail');
		$email->template('update_password', 'default')
		->from('tappware@gmail.com', 'Tappware')
		->to($receiver)
		->subject('Update Password')
		->emailFormat('html')
		->viewVars(array('name' => $name, 'pass' => $pass))
		->send();
	}

	function _generateRandomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function loadUserData($data){
		$user = $this->User->find('first', array('recursive'=>0, 'conditions'=>array('User.username'=>$data)));
		if(!empty($user)){
			return new CakeResponse(array('type'=>'application/json','body' => json_encode($user)));
		}
		else{
			return new CakeResponse(array('type'=>'application/json','body' => json_encode(1)));
		}
	}

	public function blockuser($id=null){
		if($id == null){
			if($this->request->is('post')){
				if(isset($this->request->data['User']['id']) && !empty($this->request->data['User']['id'])){
					$this->User->id = $this->request->data['User']['id'];
					$this->User->set('block_type', $this->request->data['User']['block_type']);
					$this->User->set('active', 0);
					if($this->User->save())
					{
						$this->Session->setFlash('User has been blocked !!!','flash_success');
						$this->redirect(array('controller' => 'users', 'action' => 'blocked_users'));
					}
				}
				else{
					$this->Session->setFlash('User not found.','flash_fail');
				}
			}
		}
		else{
			$this->User->id = $id;
			if($this->User->exists()){
				if($this->request->is('post')){
					$this->User->set('block_type', $this->request->data['User']['block_type']);
					if($this->request->data['User']['block_type'] == BLOCK_NO){
						$this->User->set('active', 1);
					}
					else{
						$this->User->set('active', 0);
					}
					if($this->User->save())
					{
						$this->Session->setFlash('User has been updated !!!','flash_success');
						$this->redirect(array('controller' => 'users', 'action' => 'blocked_users'));
					}
				}
				else{
					$user = $this->User->read(null, $id);
					$this->set('username', $user['User']['username']);
					$this->set('userid', $id);
					$this->set('block_type', $user['User']['block_type']);
				}
			}
			else{
				$this->Session->setFlash('User not found.','flash_fail');
			}
		}
	}

}
