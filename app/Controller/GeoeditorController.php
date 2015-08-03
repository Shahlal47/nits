<?php
App::uses('AppController', 'Controller');
/**
 * GeofenceTypes Controller
 *
 * @property GeofenceType $GeofenceType
 */
class GeoeditorController extends AppController {

	var $name = 'Geoeditor';
	var $uses = array('User');

	public function beforeFilter()
	{
		parent::beforeFilter();
		//$this->Auth->allow('index');
	}
	public function index(){

	}
	public function getdatafromdb(){
		$nearLat = $this->request->query['lat'];
		$nearLng = $this->request->query['lng'];

		$query ="SELECT * FROM (SELECT *,(((ACOS(SIN((".$nearLat."*PI()/180)) *
							SIN((lat*PI()/180))+COS((".$nearLat."*PI()/180)) *
							COS((lat*PI()/180)) * COS(((".$nearLng."- lng)
							*PI()/180))))*180/PI())) AS distance FROM latlng ORDER BY distance limit 500) AS t1 WHERE distance < 5";

		$dbc = $this->_getConnection('dbgeoinfo');
		$result = $this->_getResult($dbc,$query);

		$output = array();
		if(count($result)>0){
			$i = 0;
			while ($row = $result->fetch_assoc())
			{
				$tmp = array();
				$tmp[]=$row['lat'];
				$tmp[]=$row['lng'];
				$tmp[]=$row['address'];
				$output[] = $row;
			}
		}
		$this->_closeConnection($dbc);
		return new CakeResponse(array('body' => json_encode($output)));
	}

	public function save(){
		$id = $this->request->data['id'];
		$lat = $this->request->data['lat'];
		$lng = $this->request->data['lng'];
		$address = $this->request->data['address'];
		$placetype = $this->request->data['placetype'];
		$zoomlevel = $this->request->data['zoomlevel'];
		$remarks = $this->request->data['remarks'];
		$img = $this->request->data['img'];
		$sql = "";
		if($id=='new'){
			// insert
			$sql = "INSERT INTO latlng(lat,lng,address,placetype,zoomlevel,remarks,img)";
			$sql .= "VALUES (\"$lat\",\"$lng\",\"$address\",\"$placetype\",\"$zoomlevel\",\"$remarks\",\"$img\");";
		}else{
			// update
			$sql = "UPDATE latlng SET "; 
			$sql .= "lat = \"$lat\", lng = \"$lng\", address = \"$address\", placetype = \"$placetype\", ";
			$sql .= "zoomlevel = \"$zoomlevel\",remarks = \"$remarks\",img = \"$img\" ";
			$sql .= "WHERE index_number = \"$id\";"; 
		}
		$msg = "";
		$dbc = $this->_getConnection('dbgeoinfo');
		if($dbc==null){
			$msg = "DBERROR";
		}else{
			$result = $this->_getResult($dbc, $sql);
			if(!$result){
				//echo $sql;
				$msg = "SQLERROR";
			}else{
				$msg = "OK";
			}
			$this->_closeConnection($dbc);			
		}
		return new CakeResponse(array('body' => json_encode($msg)));
	}
	
	public function delete(){
		$id = $this->request->data['id'];
		$sql = "DELETE FROM latlng WHERE index_number = '$id';";
		$msg = "";
		$dbc = $this->_getConnection('dbgeoinfo');
		if($dbc==null){
			$msg = "DBERROR";
		}else{
			$result = $this->_getResult($dbc, $sql);
			if(!$result){
				$msg = "SQLERROR";
			}else{
				$msg = "OK";
			}
			$this->_closeConnection($dbc);			
		}
		return new CakeResponse(array('body' => json_encode($msg)));
	}
	public function nearestdatafromdb(){
		$nearLat = $this->request->query['lat'];
		$nearLng = $this->request->query['lng'];

		$query ="SELECT *,(((ACOS(SIN((".$nearLat."*PI()/180)) *
					SIN((lat*PI()/180))+COS((".$nearLat."*PI()/180)) *
					COS((lat*PI()/180)) * COS(((".$nearLng."- lng)
					*PI()/180))))*180/PI())) AS distance FROM latlng ORDER BY distance limit 5";

		$dbc = $this->_getConnection('dbgeoinfo');
		$result = $this->_getResult($dbc,$query);	

		$output = array();
		if(count($result)>0){
			$i = 0;
			while ($row = $result->fetch_assoc())
			{
				$tmp = array();
				$tmp[]=$row['index_number'];
				$tmp[]=$row['lat'];
				$tmp[]=$row['lng'];
				$tmp[]=$row['address'];
				$tmp[]=$row['placetype'];
				$tmp[]=$row['zoomlevel'];
				$tmp[]=$row['remarks'];
				$tmp[]=$row['tags'];
				$tmp[]=$row['img'];
				$output[] = $tmp;
			}
		}
		$this->_closeConnection($dbc);
		return new CakeResponse(array('body' => json_encode($output)));
	}


}

