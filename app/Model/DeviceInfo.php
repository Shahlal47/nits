<?php
App::uses('AppModel', 'Model');
/**
 * DeviceInfo Model
 *
 * @property DeviceType $DeviceType
 */
class DeviceInfo extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $useDbConfig = 'admin';


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $validate = array(
		'name' => array(
			'rule1' => array(
				'rule' => array('notempty'),
				'message' => 'Name is required and cannot be empty!!!',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'DeviceType' => array(
			'className' => 'DeviceType',
			'foreignKey' => 'device_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		);
}
