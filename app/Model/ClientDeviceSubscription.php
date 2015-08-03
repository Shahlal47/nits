<?php
App::uses('AppModel', 'Model');
/**
 * ClientDeviceSubscription Model
 *
 * @property ClientInfo $ClientInfo
 * @property ClientDevice $ClientDevice
 */
class ClientDeviceSubscription extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $useDbConfig = 'admin';
	
	public $validate = array(
			'subscribe_date' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Subscribe Date cannot be empty!!!',
							'required' => true,
					)
			),
			'expire_date' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Expired Date cannot be empty!!!',
							'required' => true,
					)
			),

	);
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
			),
			'AccountType' => array(
					'className' => 'AccountType',
					'foreignKey' => 'account_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
	);
}
