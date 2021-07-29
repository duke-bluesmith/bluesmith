<?php namespace App\Entities;

use App\Exceptions\InviteException;
use App\Libraries\Mailer;
use App\Models\InviteModel;
use App\Models\LedgerModel;
use CodeIgniter\I18n\Time;
use Tatter\Relations\Traits\EntityTrait;
use Tatter\Workflows\Entities\Job as BaseJob;

/**
 * Class Job
 *
 * An extension of Workflow's Job entity to enable
 * Relations and add a number of project-specific
 * methods and poperty stores.
 */
class Job extends BaseJob
{
	use EntityTrait;

	protected $table      = 'jobs';
	protected $primaryKey = 'id';

	/**
	 * Stored volume calculation
	 *
	 * @var int|null
	 */
	protected $volume;

	/**
	 * Stored Ledgers, indexed by "estimate" field
	 *
	 * @var array<bool,Ledger>|null
	 */
	protected $ledgers;

	/**
	 * Stored estimate Ledger
	 *
	 * @var Ledger|null
	 */
	protected $estimate;

	/**
	 * Calculates the total estimated volume based
	 * on the files associated with this job.
	 * Relies on PHPSTL having returned an accurate
	 * number, assumed to be in cubic millimeters.
	 *
	 * @return int|null Null if there were no valid file volumes
	 */
	public function getVolume(): ?int
	{
		if (isset($this->volume))
		{
			return $this->volume;
		}

		if (empty($this->files))
		{
			return null;
		}

		$count         = 0;
		$this->volume = 0;

		foreach ($this->files as $file)
		{
			if (! empty($file->volume))
			{
				$count++;
				$this->volume += $file->volume;
			}
		}

		return $count ? $this->volume : null;
	}

	/**
	 * Returns the first User associated with this Job.
	 *
	 * @return User
	 */
	public function getOwner(): ?User
	{
		if ($users = $this->users)
		{
			return reset($users);
		}

		return null;
	}

	/**
	 * Gets the estimate.
	 *
	 * @param bool $create Whether a new Ledger should be created if missing
	 *
	 * @return Ledger|null
	 */
	public function getEstimate($create = false): ?Ledger
	{
		return $this->ledger(true, $create);
	}

	/**
	 * Gets the invoice.
	 *
	 * @param bool $create Whether a new Ledger should be created if missing
	 *
	 * @return Invoice|null
	 */
	public function getInvoice($create = false): ?Invoice
	{
		if ($ledger = $this->ledger(false, $create))
		{
			return new Invoice($ledger->toRawArray());
		}

		return null;
	}

	/**
	 * Gets related Ledgers.
	 *
	 * @return array<bool,Ledger>
	 */
	public function getLedgers(): array
	{
		$this->ensureCreated();

		if (is_null($this->ledgers))
		{
			$this->ledgers = [];

			foreach (model(LedgerModel::class)->where('job_id', $this->attributes['id'])->findAll() as $ledger)
			{
				$this->ledgers[$ledger->estimate] = $ledger;
			}
		}

		return $this->ledgers;
	}

	/**
	 * Gets a Ledger.
	 *
	 * @param bool $estimate Filter for the `estimate` field
	 * @param bool $create   Whether a new Ledger should be created if missing
	 *
	 * @return Ledger|null
	 */
	protected function ledger(bool $estimate, bool $create): ?Ledger
	{
		$this->getLedgers();

		if (empty($this->ledgers[$estimate]) && $create)
		{
			$id = model(LedgerModel::class)->insert([
				'job_id'   => $this->attributes['id'],
				'estimate' => (int) $estimate,
			]);

			$this->ledgers[$estimate] = model(LedgerModel::class)->find($id);
		}

		return $this->ledgers[$estimate] ?? null;
	}

	//--------------------------------------------------------------------

	/**
	 * Creates an invitation to this job and sends it to
	 * the specified email address.
	 *
	 * @param string $recipient Email address to invite
	 *
	 * @return void
	 *
	 * @throws InviteException
	 */
	public function invite(string $recipient): void
	{
		$this->ensureCreated();

		// Check if invitations are allowed
		if (! config('Auth')->allowInvitations)
		{
			throw new InviteException(lang('Invite.disabled'));
		}

		// Make sure we have an issuer
		/** @var User|null $issuer */
		$issuer = user();
		if (! $issuer)
		{
			throw new InviteException(lang('Invite.noLogin'));
		}

		// Build the row		
		$row = [
			'job_id'     => $this->attributes['id'],
			'email'      => $recipient,
			'token'      => bin2hex(random_bytes(16)),
			'created_at' => Time::now()->toDateTimeString(),
		];

		// Check for expirations
		if ($seconds = config('Auth')->invitationLength)
		{
			$row['expired_at'] = (new Time("+{$seconds} seconds"))->toDateTimeString();
		}

		// Use the model to make the insert
		if (! model(InviteModel::class)->insert($row))
		{
			$error = implode(' ', model(InviteModel::class)->errors());
			throw new InviteException($error);
		}

		// Send the email
		Mailer::forJobInvite($issuer, $recipient, $this, $row['token']);
	}
}
