<?php
App::uses('AppModel', 'Model');
/**
 * ClientVehicle Model
 *
 * @property FuelType $FuelType
 * @property VehicleType $VehicleType
 * @property ClientInfo $ClientInfo
 * @property ClientDevice $ClientDevice
 */
class ClientVehicle extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $useDbConfig = 'admin';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'FuelType' => array(
			'className' => 'FuelType',
			'foreignKey' => 'fuel_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'VehicleType' => array(
			'className' => 'VehicleType',
			'foreignKey' => 'vehicle_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
		)
	);
}
