<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

class UserModel extends \Myth\Auth\Models\UserModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\User';

    protected $_allowedFields = ['firstname', 'lastname'];

    protected $_validationRules = [];

	/**
	 * Call the framework constructor then extend the properties.
	 *
	 * @param ConnectionInterface $db
	 * @param ValidationInterface $validation
	 */
	public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
	{
		// Call the framework constructor
		parent::__construct($db, $validation);
		
		// Merge properties with parent
		$this->allowedFields   = array_merge($this->allowedFields,   $this->_allowedFields);
		$this->validationRules = array_merge($this->validationRules, $this->_validationRules);
	}
}