<?php namespace App\Models;

use Tatter\Addins\Model;

class MethodModel extends Model
{
	protected $table      = 'methods';
	protected $primaryKey = 'id';

	protected $returnType = 'App\Entities\Method';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['name', 'summary', 'description', 'sortorder'];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
	
	protected $with = ['materials'];
}
