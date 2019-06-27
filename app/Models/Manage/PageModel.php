<?php namespace App\Models\Manage;

use App\Models\BaseModel;

class PageModel extends BaseModel
{
	protected $table      = 'pages';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = [ 'name', 'content' ];

	protected $useTimestamps = true;

	protected $validationRules    = [
		'name' => 'required'
	];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}
