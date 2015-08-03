<?php
App::uses('AppModel', 'Model');
/**
 * VehicleModel Model
 *
 * @property VehicleType $VehicleType
 */
class VehicleModel extends AppModel {
	public $useDbConfig = 'admin';
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'vehicle_model';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'VehicleType' => array(
			'className' => 'VehicleType',
			'foreignKey' => 'vehicle_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
