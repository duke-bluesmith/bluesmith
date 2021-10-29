<?php

namespace App\Entities;

use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\Entity\Entity;
use InvalidArgumentException;

/**
 * Notices Class
 *
 * Represents a single Notice for the staff dashboard.
 */
class Notice extends Entity
{
    protected $dates = ['created_at'];
    protected $casts = [
        'job_id'  => 'int',
        'user_id' => 'int',
    ];
    protected $validationRules = [
        'job_id'     => 'required|is_natural_no_zero',
        'job_name'   => 'required|string',
        'user_id'    => 'required|is_natural_no_zero',
        'user_name'  => 'required|string',
        'status'     => 'required|string',
        'content'    => 'required|string',
        'created_at' => 'required|valid_date',
    ];

    /**
     * @var Job|null
     */
    private $job;

    /**
     * @var User|null
     */
    private $user;

    /**
     * Validate input data.
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $validation = service('validation', null, false);
        if (! $validation->setRules($this->validationRules)->run($data)) {
            throw new InvalidArgumentException(implode(' ', $validation->getErrors()));
        }
    }

    /**
     * Fetches and returns the associated Job.
     *
     * @return Job
     */
    public function getJob()
    {
        if (null === $this->job) {
            $this->job = model(JobModel::class)->find($this->attributes['job_id']);
        }

        return $this->job;
    }

    /**
     * Fetches and returns the associated User.
     *
     * @return Job
     */
    public function getUser()
    {
        if (null === $this->user) {
            $this->user = model(UserModel::class)->find($this->attributes['user_id']);
        }

        return $this->user;
    }

    /**
     * Returns this Notice's sort value.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->created_at->getTimestamp();
    }
}
