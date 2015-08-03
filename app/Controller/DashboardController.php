<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */


class DashboardController extends AppController {
	public $cacheAction = true;
	
	var $name = 'Dashboard';
	var $uses = array('User','ClientInfo','ClientReport','ReportSettings');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('loadtest');
	}
	public function livetracking(){
	
	}
	public function monitoring(){
	
	}
	public function animation(){
	
	}
	public function index(){		
		$client_reports = $this->_get_reports();
		$this->set('client_reports', $client_reports);
		
		//$this->_renderDashboard();
	}
	private function _renderDashboard(){
		$role = $this->getUserRole();
		$this->set('role',$this->getUserRole());
		$this->autoRender = false;		
		if(($role=="admin")||($role=="callcenter")||($role=="accounts")){
			$this->set('userList', $this->getUserList());
			$this->render('/Dashboard/'.$role);
		}else{		
			$this->render('/Dashboard/dashboard');
		}
	}
	function getUserList()
	{
		//
		$dbc = $this->_getConnection ( 'database' );
		$rows = array ();
		if ($dbc != null) {
			$query = "select users.id as 'userid', users.username as 'username'
					  from client_infos as ci
					  left join users on users.client_info_id = ci.id
					  where ci.client_type_id > 0 group by username";
			$results = $dbc->query ( $query );
				
			if (count ( $results ) > 0) {
				while ( $row = $results->fetch_assoc () )
				{
					$rows[$row['userid']] = $row['username'];
				}
			}
		}
		//pr($rows);
		return $rows;
		
	}	
	public function dashboard(){
		$this->_renderDashboard();
	}
	public function left($left=null){
		$this->_getLogo();
		$this->autoRender = false;		
		if($left==null){
			$left = $this->getUserRole();
		}
		$user = $this->Auth->user();
		$this->set('user', $user);		
		
		if($left=="callcenter")
		{
			$this->set('userList', $this->getUserList());
		}
		
		$this->render('/LeftContent/'.$left);				
	}
	private function _getLogo(){
		$clientid = $this->getUserClientid();		
		$logo = $this->ClientInfo->find('first',array('recursive'=>'-1','fields'=>array('ClientInfo.logo'),'conditions'=>array('ClientInfo.id'=>$clientid)));
		if(!empty($logo))
		{
			$this->set('logo',$logo['ClientInfo']['logo']);
		}
	}
	private function _get_reports(){
		$client_reports = array();
		$role = $this->getUserRole();
		if($role == "single" || $role == "super" || $role == "group"){
			$clientid = $this->getUserClientid();
			$client_reports = $this->ClientReport->find('first',
					array(
									'recursive' => -1,
									'fields' => array('ClientReport.reports'),
									'conditions' => array('ClientReport.client_info_id'=>$clientid),
					)
				);
			if (!empty($client_reports)) {
				$client_reports = explode(",",$client_reports['ClientReport']['reports']);
			}
			else{
				$client_reports = array();
			}	
						
		}else{
			$client_reports = $this->ReportSettings->find('list');	
		}		
		
		return $client_reports;				
	}
}
