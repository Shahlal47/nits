<?php
App::uses('AppModel', 'Model');
/**
 * AlertType Model
 *
 */
class AlertType extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $useDbConfig = 'admin';

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
}
