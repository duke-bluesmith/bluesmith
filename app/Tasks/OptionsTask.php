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
		
		return view('tasks/options', $data);
	}
	
	public function post()
	{
		$data = $this->request->getPost();
		
		if ($data['material_id'])
		{
			$this->job->material_id = $data['material_id'];
			$this->jobs->save($this->job);
		}
		
		if (! empty($data['option_ids']) && is_array($data['option_ids']))
		{
			$this->job->setOptions($data['option_ids']);
		}
		else
		{
			$this->job->setOptions([]);
		}
		
		// End the task
		return true;
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
