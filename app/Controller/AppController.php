<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller 
{
	public $components = array('Auth','Session','Error');
	
	public function beforeFilter()
	{
		if(!isset($_SESSION)) session_start();
		$this->Auth->authenticate = array('Form');

		$this->Auth->loginRedirect = array('action' => 'index', 'controller' => 'dashboard');
		$this->Auth->logoutRedirect = array('action' => 'login', 'controller' => 'users');
		$this->Auth->authError = 'You are not allowed to see that.';

		if($this->request->is('ajax')){
			Configure::write ('debug', 0);
			$this->layout = 'ajax';
		}else{
			if ($this->params['controller'] == 'users' && $this->params['action'] == 'login') {
				$this->layout = 'login';
			}else if ($this->params['controller'] == 'animations') {
				$this->layout = 'animation';
			}else if ($this->params['controller'] == 'monitoring') {
				$this->layout = 'monitoring';
			}else if ($this->params['controller'] == 'trackerTracks' && $this->params['action'] == 'tracker_live_view') {
				$this->layout = 'livetracking';
			}
			else if ($this->params['controller'] == 'trackerTracks' && $this->params['action'] == 'report_live_view') {
				$this->layout = 'livetracking';
			}else if ($this->params['controller'] == 'clientDevices' && $this->params['action'] == 'livetracker') {
				$this->layout = 'singletracker';
			}else if ($this->params['controller'] == 'clientInfos' && $this->params['action'] == 'logo') {
				$this->layout = 'iframe';
			}else if ($this->params['controller'] == 'trackerTracks') {
				$this->layout = 'default_tracker';
			}else{	
				$this->set('auth',$this->Auth);
			}	
			$this->setLayout();					
		}		
	}	
	
	public function setLayout(){
		//$this->layout = $role;
		$this->set('role',$this->getUserRole());
		$this->set('user',$this->getUserSession());		
	}
	
	public function allowIfUserIsActive(){
		$args = func_get_args();
		$curaction = $this->request->params['action'];
		foreach ($args as &$value) {
		  	if($value==$curaction){
				if($this->Session->read('Auth.User.id')){
					if($this->Session->read('Auth.User.is_active')==0){
						$this->autoRender = false;
						$this->render('/Elements/email_verify');
					}
				} 				
		  	}  
		}
	}

	public function getUserSession(){
		return $this->Auth->user();
	}
	public function getAjaxplaceholder(){
		$role = $this->getUserRole();
		if($role=='admin'){
			return '#ajaxClientInfo';
		}			
		return '#ajax-content';
	}
	public function getUserRole(){
		$t = $this->Auth->user();
		return $t['UserType']['name'];
	}
	public function getUserClientid(){
		$t = $this->Auth->user();
		return $t['client_info_id'];
	}
	public function getUserContactid(){
		$t = $this->Auth->user();
		return $t['client_contact_id'];
	}
	
	public function ifSchoolSystemAdmin(){
		$role = $this->getUserRole();
		if($role=="systemadmin"){
			return true;
		}
		return false;
	}
	public function getRoles(){
		$roles = array(
					//"superadmin"=>"superadmin",
					"systemadmin"=>"systemadmin",
					"administration"=>"administration",
					"student"=>"student",
					"teacher"=>"teacher",
					"parent"=>"parent",
		);
		return $roles;
	}
	
	public function _getConnection($dbname){
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->default['datasource'] === 'Database/Mysql') {			
			$dbc = new mysqli($DB->default['host'], $DB->default['login'], $DB->default['password'], $DB->default[$dbname]);

			// Make sure we use UTF8 encoding
			if($DB->default['encoding'] == "UTF8") {
				$dbc->set_charset($DB->default['encoding']);
			}
			return $dbc;
		}
		printf("Errormessage: %s\n", $mysqli->error);
		return null;
	}
	
	public function _getConnectionAdmin($dbname){
		require_once(dirname(__FILE__) . '/../Config/database.php');
		$DB = new DATABASE_CONFIG();
		if($DB->admin['datasource'] === 'Database/Mysql') {
			$dbc = new mysqli($DB->admin['host'], $DB->admin['login'], $DB->admin['password'], $DB->admin[$dbname]);
	
			// Make sure we use UTF8 encoding
			if($DB->admin['encoding'] == "UTF8") {
				$dbc->set_charset($DB->admin['encoding']);
			}
			return $dbc;
		}
		printf("Errormessage: %s\n", $mysqli->error);
		return null;
	}
	public function _closeConnection($dbc){
		$dbc->close();
	}
	public function _getResult($dbc,$query){
		$results = $dbc->query($query);
		return $results;
	}
	
	public function _getRowCount($dbc,$query){
		$results = $dbc->query($query);
		$allRows = $results->rowCount();
		return $results;
	}
	public function _execute($dbc,$query){
		$results = $dbc->query($query);
		return $results;
	}
	public function _getRow($dbc,$query){
		$results = $dbc->query($query);
		if($results){
			$results = $results->fetch_array();
			return $results;
		}
		else{
			return null;
		}
	}	
}


