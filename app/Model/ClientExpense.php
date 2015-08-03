<?php
App::uses('AppModel', 'Model');
/**
 * ClientExpense Model
 *
 * @property ClientInfo $ClientInfo
 * @property ExpenseType $ExpenseType
 * @property ClientDevice $ClientDevice
 */
class ClientExpense extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $useDbConfig = 'admin';

	public $validate = array(
			'client_device_id' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Vehicle Registration Number is required and cannot be empty!!!',
							'required' => true
					)
			),
			'ondate' => array(
					'rule1' => array(
							'rule' => array('date'),
							'message' => 'Invalid Date!!!',
							'required' => true
					)
			),
			'amount' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Amount is required and cannot be empty!!!',
							'required' => true
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
			'ClientDevice' => array(
					'className' => 'ClientDevice',
					'foreignKey' => 'client_device_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
			'ExpenseType' => array(
					'className' => 'ExpenseType',
					'foreignKey' => 'expense_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
	);
}
