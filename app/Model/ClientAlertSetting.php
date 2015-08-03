<?php
App::uses('AppModel', 'Model');
/**
 * ClientAlertSetting Model
 *
 * @property ClientInfo $ClientInfo
 * @property AlertType $AlertType
 * @property ClientContact $ClientContact
 * @property ClientDevice $ClientDevice
 */
class ClientAlertSetting extends AppModel {


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
		),
		'AlertType' => array(
			'className' => 'AlertType',
			'foreignKey' => 'alert_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ClientContact' => array(
			'className' => 'ClientContact',
			'foreignKey' => 'client_contact_id',
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
