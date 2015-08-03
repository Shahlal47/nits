<?php
App::uses('AppModel', 'Model');
/**
 * ClientDevice Model
 *
 * @property ClientInfo $ClientInfo
 * @property DeviceType $DeviceType
 * @property VehicleType $VehicleType
 * @property AccountType $AccountType
 * @property ClientContact $ClientContact
*/
class ClientDevice extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';
	public $useDbConfig = 'admin';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $validate = array(
			'deviceid' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Device ID is required and cannot be empty!!!',
							'required' => true,
					),
					'rule2' => array(
							'rule' => array('numeric'),
							'message' => 'Device ID must be numeric!!!',
							'required' => true,
					),
					'rule3' => array(
							'rule' => array('between', 8, 8),
							'message' => 'Device ID must be 8 digits!!!',
							'required' => true,
					),
					'rule4' => array(
							'rule' => 'isUnique',
							'message' => 'Device ID exist!!!',
							'required' => 'create'
					),
			),
			'tracker_id' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Tracker ID is required and cannot be empty!!!',
							'required' => true,
					),
					'rule2' => array(
							'rule' => array('alphaNumeric'),
							'message' => 'Invalid Characters!!!',
							'required' => true,
					),
					'rule3' => array(
						'rule' => 'isUnique',
						'message' => 'Tracker ID exist!!!',
						'required' => 'create'
					)
					
			),
			'name' => array(
				'rule1' => array(
					'rule' => array('notempty'),
					'message' => 'This field cannot be empty!!!',
					'required' => true,
				)
			),
			'mob_no' => array(
				'rule1' => array(
					'rule' => array('notempty'),
					'message' => 'Device cell number must be provided!!!',
					'required' => true,
				),
				'rule2' => array(
						'rule' => array('numeric'),
						'message' => 'Invalid Device cell number!!!',
						'required' => true,
				),
			),
			'speed_limit' => array(
					'rule1' => array(
							'rule' => array('numeric'),
							'message' => 'Invalid Characters!!!',
							'allowEmpty' => true
					)
			),
			'minimum_mileage' => array(
					'rule1' => array(
							'rule' => array('numeric'),
							'message' => 'Invalid Characters!!!',
							'allowEmpty' => true
					)
			),
			'maintenance_mileage' => array(
					'rule1' => array(
							'rule' => array('numeric'),
							'message' => 'Invalid Characters!!!',
							'allowEmpty' => true
					)
			),
			'fuel_consumption' => array(
					'rule1' => array(
							'rule' => array('numeric'),
							'message' => 'Invalid Characters!!!',
							'allowEmpty' => true
					)
			)
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

			'DeviceInfo' => array(
					'className' => 'DeviceInfo',
					'foreignKey' => 'device_info_id',
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
			'DeviceType' => array(
					'className' => 'DeviceType',
					'foreignKey' => 'device_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
			'ClientDeviceSubscription' => array(
					'className' => 'ClientDeviceSubscription',
					'foreignKey' => 'client_device_subscription_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
							),


	);
}
