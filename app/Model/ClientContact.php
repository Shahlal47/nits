<?php
App::uses('AppModel', 'Model');
/**
 * ClientContact Model
 *
 * @property ClientInfo $ClientInfo
 * @property User $User
*/
class ClientContact extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';
	public $useDbConfig = 'admin';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
// 			'name' => array(
// 					'rule1' => array(
// 							'rule' => array('notempty'),
// 							'message' => 'Contact Name is required and cannot be empty!!!',
// 							//'allowEmpty' => false,
// 							'required' => true,
// 							//'last' => false, // Stop validation after this rule
// 							//'on' => 'create', // Limit validation to 'create' or 'update' operations
// 					)
// 			),
			'mobile' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Mobile number is required and cannot be empty!!!',
							//'allowEmpty' => false,
							'required' => true,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
					'rule2' => array(
							'rule' => array('numeric'),
							'message' => 'Invalid Mobile Number!!!',
							'required' => true,
					)
			),
			/*'mobile_home' => array(
					'rule1' => array(
							'rule' => array('notempty'),
							'message' => 'Mobile number is required and cannot be empty!!!',
							'required' => true
					),
					'rule2' => array(
							'rule' => array('numeric'),
							'message' => 'Invalid Mobile Number!!!',
							'required' => true
					)
			),
			'mobile_office' => array(
					'rule1' => array(
					'rule' => array('notempty'),
					'message' => 'Mobile number is required and cannot be empty!!!',
					'required' => true
					),
					'rule2' => array(
							'rule' => array('numeric'),
							'message' => 'Invalid Mobile Number!!!',
							'required' => true
					)
			),
			'mobile_home' => array(
					'allowEmpty' => true,
			),
			'mobile_office' => array(
					'allowEmpty' => true,
			),*/
			'email' => array(
					'rule' => array('email'),
					'message' => 'Invalid email address!!!',
					'allowEmpty' => true,
			),
			'nationalid' => array(
					'rule1' => array(
					'rule' => array('numeric'),
					'message' => 'Invalid National ID!!!',
					'allowEmpty' => true,
					),
			)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			)
	);
}
