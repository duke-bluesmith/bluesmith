<?php namespace App\Actions;

use App\BaseAction;
use App\Models\PageModel;

class TermsAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Define',
		'name'     => 'Terms',
		'uid'      => 'terms',
		'role'     => 'user',
		'icon'     => 'fas fa-actions',
		'summary'  => 'Client accepts terms of service',
	];

	public function get()
	{
		return view('actions/terms', [
			'job'   => $this->job,
			'page'  => model(PageModel::class)->where('name', 'TOS')->first(),
		]);
	}

	public function post()
	{
		$data = service('request')->getPost();

		if (empty($data['accept']))
		{
			alert('warning', lang('Actions.mustAccept'));
			return redirect()->back();
		}

		$this->job->setFlag('Accepted');

		// End the action
		return true;
	}

	/**
	 * Runs when job regresses back through the workflow.
	 *
	 * @return mixed
	 */
	public function down()
	{
		// Remove acceptance
		$this->job->clearFlag('Accepted');

		return true;
	}
}
