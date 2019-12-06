<?php namespace App\Models;

class PageModel extends BaseModel
{
	protected $table           = 'pages';
	protected $allowedFields   = [ 'name', 'content' ];
	protected $validationRules = [
		'name' => 'required'
	];
}
