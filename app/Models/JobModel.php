<?php namespace App\Models;

use CodeIgniter\Model;

class JobModel extends \Tatter\Workflows\Models\JobModel
{
	protected $allowedFields = ['name', 'summary', 'description'];
}
