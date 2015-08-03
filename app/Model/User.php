<?php 
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
	public $useDbConfig = 'admin';
	public $name = 'User';

	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password']))
		{
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

	public $validate = array(
			'username' => array(
					array(
							'rule' => array('notEmpty'),
							'message' => 'A username is required.'
					),
					array(
							'rule' => 'alphaNumeric',
							'message' => 'User Name should be alpha-numeric.'
					)
					,
					array(
							'rule' => 'isUnique',
							'message' => 'This username already exists.'
					)
			),
			'password' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'A password is required',
					)
			),
			'email' => array(
					'rule1' => array(
							'rule' => array('email'),
							'message' => 'Invalid Email!!!',
							'allowEmpty' => true,
					)
			),
	);
	public $belongsTo = array(
			'ClientInfo' => array(
					'className' => 'ClientInfo',
					'foreignKey' => 'client_info_id',
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
			'UserType' => array(
					'className' => 'UserType',
					'foreignKey' => 'user_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
	);
	public function generateHashChangePassword()
	{
		$salt = Configure::read('Security.salt');
		$salt_v2 = Configure::read('Security.cipherSeed');
		$rand = mt_rand(1,999999999);
		$rand_v2 = mt_rand(1,999999999);

		$hash = hash('sha256',$salt.$rand.$salt_v2.$rand_v2);

		return $hash;
	}


}
?>
