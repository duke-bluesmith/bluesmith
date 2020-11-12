<?php namespace App\Models;

use App\Entities\User;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Myth\Auth\Models\UserModel as MythModel;
use Tatter\Permits\Interfaces\PermitsUserModelInterface;

class UserModel extends MythModel implements PermitsUserModelInterface
{
	protected $table      = 'users';
	protected $primaryKey = 'id';
	protected $returnType = User::class;

	protected $_allowedFields   = ['firstname', 'lastname'];
	protected $_validationRules = [];

	/**
	 * Call the framework constructor then add the extended properties.
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

	/**
	 * Returns groups for a single user.
	 *
	 * @param mixed $userId = null
	 *
	 * @return \stdClass[] Array of group objects
	 */
	public function groups($userId = null): array
	{
		return $this->db->table('auth_groups')
			->select('auth_groups.*')
			->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id', 'left')
			->where('auth_groups_users.user_id', $userId)
			->get()->getResultObject();
	}
}
