<?php
App::uses('AppModel', 'Model');
/**
 * TransferHistory Model
 *
 */
class TransferHistory extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'device_id';
	public $useTable = 'transfer_history';
}
