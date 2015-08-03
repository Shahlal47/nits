<?php
App::uses('AppModel', 'Model');
/**
 * ClientContactDevice Model
 *
 * @property ClientContact $ClientContact
 * @property ClientDevice $ClientDevice
 */
class ClientContactDevice extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $displayField = 'client_device_id';
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
		)
	);
}
