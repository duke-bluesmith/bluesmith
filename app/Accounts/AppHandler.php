<?php namespace App\Accounts;

use CodeIgniter\Model;
use App\Entities\User;
use App\Models\UserModel;
use Tatter\Accounts\Entities\Account;
use Tatter\Accounts\Handlers\MythHandler;

class AppHandler extends MythHandler
{
	/**
	 * Internal fields supported by this handler.
	 *
	 * @var array
	 */
	protected $fields = [
		'id'       => 'id',
		'email'    => 'email',
		'name'     => 'name',
		'active'   => 'valid',
	];

	/**
	 * Load or store the model
	 *
	 * @param Model $model  Instance of the model, or null to load UserModel
	 */
	public function __construct(Model $model = null)
	{
		$this->source = $model ?? new UserModel();
	}

	/**
	 * Wrap original source data into an Account based on $fields.
	 * Provides override for merging names
	 *
	 * @param User $user  Result from the model
	 *
	 * @return Account
	 */
	protected function wrap($user): Account
	{
		$account = parent::wrap($user);

		// Check for the off chance that it comes back with a name already
		if (empty($account->name))
		{
			// Use the entity magic getter to merge first+last
			$account->name = $user->name;
		}

		return $account;
	}
}
