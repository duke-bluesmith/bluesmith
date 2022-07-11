<?php

namespace App\Models;

use App\Entities\Invite;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;

/**
 * @psalm-suppress MethodSignatureMismatch
 */
class InviteModel extends BaseModel
{
    protected $table          = 'invites';
    protected $returnType     = Invite::class;
    protected $useTimestamps  = false;
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'job_id',
        'email',
        'token',
        'created_at',
        'expired_at',
    ];
    protected $validationRules = [
        'job_id' => 'required|integer',
        'email'  => 'required|valid_email',
        'token'  => 'required|hex',
    ];

    /**
     * Returns the inivitation matching the token.
     */
    public function findByToken(string $token): ?Invite
    {
        if ($token === '') {
            return null;
        }

        return $this->where('token', $token)->first();
    }

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): Invite
    {
        return new Invite([
            'job_id' => random_int(1, Fabricator::getCount('jobs') ?: 10),
            'email'  => $faker->email,
            'token'  => $faker->md5,
        ]);
    }
}
