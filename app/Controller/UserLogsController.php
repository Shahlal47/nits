<?php
App::uses('AppController', 'Controller');
/**
 * UserLogs Controller
 *
 * @property UserLog $UserLog
 */
class UserLogsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index($userid = null) {
		if($userid){
			$this->UserLog->User->id = $userid;
			if (!$this->UserLog->User->exists()) {
				throw new NotFoundException(__('Invalid user id'));
			}
			$user = $this->UserLog->User->read(null, $userid);
			$this->set('username', ' for [ '.$user['User']['username'].' ]');			
		}
		$this->set(compact('userid'));
	}
	
	public function jsondata(){

		$fields = array('UserLog.id','User.username','UserType.name','UserLog.created');
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

		$orderby[] = array('UserLog.created DESC');
/*		if ( isset( $this->request->query['iSortCol_0'] ) )
		{
			for ( $i=0 ; $i<intval( $this->request->query['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($this->request->query['iSortCol_'.$i]) ] == "true" )
				{
					$orderby[] = $fields[ intval( $this->request->query['iSortCol_'.$i] ) ]." ".$this->request->query['sSortDir_'.$i];
				}
			}
		}*/
		
		


		$and[] = array('1'=>1);		
		// 
		$userid = isset($this->request->query['user_id'])?$this->request->query['user_id']:null;
		if($userid!=null){
			$and[] = array('user_id'=>$userid);	
		}
		
					
		if(count($and)>1){
			$conditions = array('AND' => $and);
		}else{
			$conditions = $and;
		}
		 
		$result = $this->UserLog->find('all',
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
		$iTotal = $this->UserLog->find('count',array('conditions' => $conditions));

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
