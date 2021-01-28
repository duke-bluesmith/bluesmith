<?php namespace App\Actions;

use App\BaseAction;
use App\Models\MethodModel;
use App\Models\OptionModel;

class OptionsAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Define',
		'name'     => 'Print Options',
		'uid'      => 'options',
		'role'     => 'user',
		'icon'     => 'fas fa-cogs',
		'summary'  => 'Client specifies method, materials, and options',
	];

	public function get()
	{
		$options = new OptionModel();
		$methods = new MethodModel();

		$data = [
			'job'     => $this->job,
			'methods' => $methods->with('materials')->findAll(),
			'options' => $options->findAll(),
		];

		return view('actions/options', $data);
	}

	public function post()
	{
		$data = service('request')->getPost();

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

		// End the action
		return true;
	}
}
