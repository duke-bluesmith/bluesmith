<?php namespace App\Actions;

use App\BaseAction;
use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class PaymentAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Complete',
		'name'     => 'Payment',
		'uid'      => 'payment',
		'role'     => 'user',
		'icon'     => 'fas fa-money-check',
		'summary'  => 'Client submits payment for charges',
	];

	public function get()
	{
		// Load Merchants and filter by eligibility
		$merchants = [];
		foreach (service('handlers', 'Merchants')->findAll() as $class)
		{
			$merchant = new $class();
			if ($merchant->eligible(user()))
			{
				$merchants[] = $merchant;
			}
		}

		return view('actions/payment/index', [
			'job'       => $this->job,
			'invoice'   => $this->job->getInvoice(),
			'merchants' => $merchants,
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
		$name     = service('request')->getPost('merchant');
		$class    = service('handlers', 'Merchants')->find($name);
		$merchant = new $class();

		return $merchant->request($this->job->getInvoice());
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
