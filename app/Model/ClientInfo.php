<?php
App::uses('AppModel', 'Model');
/**
 * ClientInfo Model
 *
 * @property ClientType $ClientType
 * @property CompanyType $CompanyType
 * @property User $User
 * @property Contact $Contact
*/
class ClientInfo extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';
	public $useDbConfig = 'admin';

	public $uploadDir = 'files/logo';

	public function beforeSave($options = array())
	{

		if (isset($this->data[$this->alias]['password']))
		{
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		if (!empty($this->data[$this->alias]['filepath'])) {
			$this->data[$this->alias]['filename'] = $this->data[$this->alias]['filepath'];
		}

		return parent::beforeSave($options);
		//return true;
	}
	
	public function beforeValidate($options = array()) {
		// ignore empty file - causes issues with form validation when file is empty and optional
		if (!empty($this->data[$this->alias]['filename']['error']) && $this->data[$this->alias]['filename']['error']==4 && $this->data[$this->alias]['filename']['size']==0) {
			unset($this->data[$this->alias]['filename']);
		}

		parent::beforeValidate($options);
	}

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
			),
			'filename' => array(
				   'uploadError' => array(
				   		'rule' => 'uploadError',
				   		'message' => 'Something went wrong with the file upload',
				   		'required' => FALSE,
				   		'allowEmpty' => TRUE,
				   ),
					// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::mimeType
					'mimeType' => array(
							'rule' => array('mimeType', array('image/gif','image/png','image/jpg','image/jpeg')),
							'message' => 'Invalid file, only images allowed',
							'required' => FALSE,
							'allowEmpty' => TRUE,
					),
					// custom callback to deal with the file upload
					'processUpload' => array(
							'rule' => 'processUpload',
							'message' => 'Something went wrong processing your file',
							'required' => FALSE,
							'allowEmpty' => TRUE,
							'last' => TRUE,
					)
			),

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	*/
	public $belongsTo = array(
			'ClientType' => array(
					'className' => 'ClientType',
					'foreignKey' => 'client_type_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
			'CompanyType' => array(
					'className' => 'CompanyType',
					'foreignKey' => 'company_type_id',
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
			),
			'ClientContact' => array(
					'className' => 'ClientContact',
					'foreignKey' => 'client_contact_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
	);
		
		
	/**
	 * Process the Upload
	 * @param array $check
	 * @return boolean
	*/
	public function processUpload($check=array()) {
		// deal with uploaded file
		if (!empty($check['filename']['tmp_name'])) {

			// check file is uploaded
			if (!is_uploaded_file($check['filename']['tmp_name'])) {
				return TRUE;
			}
			$fname = pathinfo($check['filename']['id'], PATHINFO_FILENAME).'.'.pathinfo($check['filename']['name'], PATHINFO_EXTENSION);
			// build full filename
			$filename = WWW_ROOT . $this->uploadDir . DS . Inflector::slug(pathinfo($check['filename']['id'], PATHINFO_FILENAME)).'.'.pathinfo($check['filename']['name'], PATHINFO_EXTENSION);


			// try moving file
			if (!move_uploaded_file($check['filename']['tmp_name'], $filename)) {
				return TRUE;

				// file successfully uploaded
			} else {
				// save the file path relative from WWW_ROOT e.g. uploads/example_filename.jpg
				$this->data[$this->alias]['filepath'] = str_replace(DS, "/", str_replace(WWW_ROOT, "", $filename) );
				$this->data[$this->alias]['logo'] = str_replace('-','_',$fname);
			}
		}

		return TRUE;
	}
}
