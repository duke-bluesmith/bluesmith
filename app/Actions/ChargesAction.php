<?php namespace App\Actions;

use App\Models\ChargeModel;
use Tatter\Workflows\BaseAction;

class ChargesAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Assess',
		'name'     => 'Charges',
		'uid'      => 'charges',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-file-invoice-dollar',
		'summary'  => 'Staff reviews submission and sets charges',
	];
	
	public function get()
	{
		helper(['form', 'inflector']);

		return view('actions/charges', [
			'job' => $this->job,
		]);
	}
	
	public function post()
	{
		$data = service('request')->getPost();

		// End the action
		return true;
	}
	
	public function put()
	{
		$data = service('request')->getPost();

		// Convert the input into fractional money units
		$data['price']  = $data['price'] * service('settings')->currencyScale;
		$data['job_id'] = $this->job->id;

		// Add the Charge
		if (! model(ChargeModel::class)->insert($data))
		{
			return redirect()->back()->withInput()->with('error', implode(' ', model(ChargeModel::class)->errors()));
		}

		return redirect()->back();
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
