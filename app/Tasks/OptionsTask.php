<?php namespace App\Tasks;

use App\Models\MethodModel;
use App\Models\OptionModel;
use Tatter\Workflows\Interfaces\TaskInterface;

class OptionsTask implements TaskInterface
{
	use \Tatter\Workflows\Traits\TasksTrait;
	
	public $definition = [
		'category' => 'Define',
		'name'     => 'Print Options',
		'uid'      => 'options',
		'icon'     => 'fas fa-cogs',
		'summary'  => 'Client specifies method, materials, and options',
	];
	
	public function get()
	{
		helper(['form', 'inflector']);
		$options = new OptionModel();
		$methods = new MethodModel();
		
		$data = [
			'job'     => $this->job,
			'methods' => $methods->with('materials')->findAll(),
			'options' => $options->findAll(),
		];
		
		return view('jobs/options', $data);
	}
	
	public function post()
	{

	}
	
	public function put()
	{

	}
	
	// run when a job progresses forward through the workflow
	public function up()
	{
	
	}
	
	// run when job regresses back through the workflow
	public function down()
	{

	}
}
