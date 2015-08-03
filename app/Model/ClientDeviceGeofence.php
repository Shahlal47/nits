<?php
App::uses('AppModel', 'Model');
/**
 * ClientDeviceGeofence Model
 *
 * @property ClientContact $ClientContact
 * @property ClientDevice $ClientDevice
 * @property Geofence $Geofence
 */
class ClientDeviceGeofence extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $useDbConfig = 'admin';
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
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
		),
		'Geofence' => array(
			'className' => 'Geofence',
			'foreignKey' => 'geofence_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
