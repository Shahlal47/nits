<?php
App::uses('AppController', 'Controller');
class TrackerEyesController extends AppController {

	var $uses = array('ClientDevice','ClientContactDevice', 'ClientInfo', 'ClientContact', 'User');

	public function trackersSummary(){
		
	}
	
	public function getImageList()
	{
		ini_set('memory_limit', '-1');
		set_time_limit(0);
		
		$sdate = $this->request->data['sdate'];
		$sdate_date = substr($sdate,2);
		/*Remove dash from date*/
		$match_date = str_replace("-","",$sdate_date);
		
		$deviceid = $this->request->data['deviceid'];
		
		$matches = array ();
		$img_names = array();
		
		preg_match_all ( "/(a href\=\")([^\?\"]*)(\")/i", $this->get_text ( 'http://115.69.209.139/nits/'.$deviceid ), $matches );
		foreach ( $matches [2] as $match ) {
			if ($match != "/nits/") {
				$split_match_name = split("_", $match);
				$lat = $split_match_name[2];
				$lng = $split_match_name[3];
				
				$lat = substr($lat, 0, 2) . '.' . substr($lat, 2);
				$lng = substr($lng, 0, 2) . '.' . substr($lng, 2, 4);
				
				$date_part = $split_match_name[1];
				$split_date_from_date_time = substr($date_part,0,6);
				$split_time_from_date_time = substr($date_part,6,6);
				
				$time_str = substr($split_time_from_date_time,0,2) .":".substr($split_time_from_date_time,2,2).":".substr($split_time_from_date_time,4,2);
				
				$date_time=$sdate." ".$time_str;
				
				$timestamp = strtotime($date_time);
				$timestamp += 6 * 3600;
				//echo date('Y-m-d H:i:s', $timestamp);
				
				
				//echo date('Y-m-d H:i:s', $timestamp);
				$time_str=date('Y-m-d H:i:s', $timestamp);
				
				if($match_date == $split_date_from_date_time){
					$info = array();
					$info['lat'] = $lat;
					$info['lng'] = $lng;
					$info['time'] = $time_str;
					$info['image'] = 'http://115.69.209.139/nits/'.$deviceid.'/'.$match;
					$img_names[] = $info;
				}
			}
		}
		return new CakeResponse(array('type'=>'application/json', 'body'=>json_encode($img_names)));
	}
	
	function get_text($filename) {
		$fp_load = fopen ( "$filename", "rb" );
		$content = '';
		if ($fp_load) {
	
			while ( ! feof ( $fp_load ) ) {
				$content .= fgets ( $fp_load, 8192 );
			}
	
			fclose ( $fp_load );
	
			return $content;
		}
	}

}
