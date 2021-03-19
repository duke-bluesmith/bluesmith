<?php namespace App\Models;

use App\Entities\User;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Faker\Generator;
use Myth\Auth\Entities\User as MythUser;
use Myth\Auth\Models\UserModel as MythModel;
use Tatter\Permits\Interfaces\PermitsUserModelInterface;
use stdClass;

class UserModel extends MythModel implements PermitsUserModelInterface
{
	use CompiledRowsTrait;

	protected $table      = 'users';
	protected $primaryKey = 'id';
	protected $returnType = User::class;

	protected $_allowedFields   = ['firstname', 'lastname', 'balance'];
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
	 * @return stdClass[] Array of group objects
	 */
	public function groups($userId = null): array
	{
		return $this->db->table('auth_groups')
			->select('auth_groups.*')
			->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id', 'left')
			->where('auth_groups_users.user_id', $userId)
			->get()->getResultObject();
	}

	/**
	 * Fetch or build the compiled rows for browsing,
	 * applying filters, and sorting.
	 *
	 * @return array[]
	 */
	protected function fetchCompiledRows(): array
	{
		return $this->builder()
			->select('users.*, auth_groups.id AS group_id, auth_groups.name as group')
			->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
			->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'left')
			->get()->getResultArray();
	}

	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return User
	 */
	public function fake(Generator &$faker): MythUser
	{
		return new User([
			'email'     => $faker->email,
			'username'  => $faker->userName,
			'firstname' => $faker->firstName,
			'lastname'  => $faker->lastName,
			'password'  => bin2hex(random_bytes(24)),
			'balance'   => rand(0, 1) ? rand(100, 5000) : 0,
			'active'    => (bool) rand(0, 20),
		]);
	}
}
