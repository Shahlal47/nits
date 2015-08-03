<?php
App::uses('AppModel', 'Model');
/**
 * ClientReport Model
 *
 * @property ClientInfo $ClientInfo
 */
class ClientReport extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $useDbConfig = 'admin';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ClientInfo' => array(
			'className' => 'ClientInfo',
			'foreignKey' => 'client_info_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
