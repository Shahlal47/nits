<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */
class MonitoringController extends AppController {
	var $name = 'Monitoring';
	var $uses = array('User');  //'Recipe',
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		//$this->Auth->allow('index');
	}
	public function index(){
		//$user = $this->Auth->user();
		//$role = $user['UserType']['name'];
		
		//return new CakeResponse(array('body' => '<script>$(function(){monitoring();});</script>'));	
	}

	public function monitoring(){
		
	}
	private function getUserTrackerList(){
	
	}
	
}
