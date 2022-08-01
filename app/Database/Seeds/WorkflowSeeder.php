<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tatter\Workflows\Entities\Workflow;
use Tatter\Workflows\Models\StageModel;
use Tatter\Workflows\Models\WorkflowModel;

class WorkflowSeeder extends Seeder
{
    /**
     * Actions to insert
     *
     * @var array<string, bool> ID => required
     */
    protected $actions = [
        'info'      => false,
        'files'     => false,
        'options'   => true,
        'clients'   => true,
        'terms'     => true,
        'charges'   => false,
        'estimate'  => false,
        'approve'   => true,
        'print'     => true,
        'postprint' => false,
        'invoice'   => false,
        'payment'   => true,
        'deliver'   => true,
    ];

    /**
     * @var string
     */
    protected $description = <<<'EOT'
        	<ol>
        		<li>Upload your files you want printed.</li>
        		<li>Add print options and any specific instructions.</li>
        		<li>Our staff will assess your submission and issue you an estimate. Typically this takes 1-2 business days, but during busy times may be a week.</li>
        		<li>Review and approve the estimate.</li>
        		<li>Once the job is approved our staff will print it and notify you when it is done.</li>
        		<li>After printing is completed, pay for your job before pickup. Payment can be in the form of Credit Card, Fundcodes, Bluechips, or Invoices.</li>
        		<li>Come to the studio to pickup your job.
        	</ol>
        EOT;

    public function run()
    {
        $workflows = model(WorkflowModel::class);

        // If there's already a workflow then quit
        if ($workflows->first()) {
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

        /**
         * Get the new workflow
         *
         * @var Workflow $workflow
         */
        $workflow = $workflows->find($id);

        // Create the stages in a specific order
        foreach ($this->actions as $actionId => $required) {
            model(StageModel::class)->insert([
                'action_id'   => $actionId,
                'workflow_id' => $workflow->id,
                'required'    => (int) $required,
            ]);
        }
    }
}
