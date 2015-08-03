<?php
App::uses('AppModel', 'Model');
/**
 * Geofence Model
 *
 * @property ClientDevice $ClientDevice
 * @property GeofenceType $GeofenceType
 * @property ClientDevice $ClientDevice
 */
class Geofence extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $useDbConfig = 'admin';
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
	);

}
