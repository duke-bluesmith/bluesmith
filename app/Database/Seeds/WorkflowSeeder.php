<?php namespace App\Database\Seeds;

use Tatter\Workflows\Entities\Workflow;
use Tatter\Workflows\Models\WorkflowModel;
use Tatter\Workflows\Registrar;
use CodeIgniter\Database\Seeder;

class WorkflowSeeder extends Seeder
{
	/**
	 * @var array Actions to insert
	 */
	protected $actions = [
		'info',
		'files',
		'options',
		'clients',
		'terms',
		'charges',
		'estimate',
		'approve',
		'print',
		'postprint',
		'invoice',
		'payment',
		'deliver',
	];

	/**
	 * @var string
	 */
	protected $description = '
	<ol>
		<li>Upload your files you want printed.</li>
		<li>Add print options and any specific instructions.</li>
		<li>Our staff will assess your submission and issue you an estimate. Typically this takes 1-2 business days, but during busy times may be a week.</li>
		<li>Review and approve the estimate.</li>
		<li>Once the job is approved our staff will print it and notify you when it is done.</li>
		<li>After printing is completed, pay for your job before pickup. Payment can be in the form of Credit Card, Fundcodes, Bluechips, or Invoices.</li>
		<li>Come to the studio to pickup your job.
	</ol>';

	public function run()
	{
		$workflows = new WorkflowModel();

		// If there's already a workflow then quit
		if ($workflows->first())
		{
			return;
		}

		// Create the default workflow
		$id = $workflows->insert([
			'name'        => 'Default Workflow',
			'category'    => 'Core',
			'icon'        => 'far fa-smile',
			'summary'     => 'Traditional print job workflow',
			'description' => $this->description,
		]);

		// Get the new workflow
		$workflow = $workflows->find($id);
		/* @var Workflow $workflow */

		// Make sure all Actions are registered
		Registrar::actions();

		// Create the stages in a specific order
		foreach ($this->actions as $uid)
		{
			$workflow->addAction($uid);
		}
	}
}
