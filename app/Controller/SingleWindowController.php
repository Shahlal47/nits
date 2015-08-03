<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */


class SingleWindowController extends AppController {
	public $cacheAction = true;
	
	var $name = 'SingleWindow';
	var $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		//$this->Auth->allow('loadtest');
	}
	public function livetracking(){
		
	}
	public function monitoring(){
	
	}
	public function animation(){
	
	}
}
