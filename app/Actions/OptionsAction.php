<?php namespace App\Actions;

use App\BaseAction;
use App\Models\MethodModel;
use App\Models\OptionModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class OptionsAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Define',
		'name'     => 'Print Options',
		'uid'      => 'options',
		'role'     => '',
		'icon'     => 'fas fa-cogs',
		'summary'  => 'Client specifies method, materials, and options',
	];

	/**
	 * Displays the options form.
	 *
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface
	{
		return $this->response->setbody(view('actions/options', [
			'job'     => $this->job,
			'methods' => model(MethodModel::class)->with('materials')->findAll(),
			'options' => model(OptionModel::class)->findAll(),
		]));
	}

	/**
	 * Processes form submission.
	 *
	 * @return null
	 */
	public function post(): ?ResponseInterface
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
		return null;
	}
}
