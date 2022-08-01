<?php

namespace App\Actions;

use App\BaseAction;
use App\Models\ChargeModel;
use App\Models\LedgerModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Workflows\Entities\Job;

class ChargesAction extends BaseAction
{
    public const HANDLER_ID = 'charges';
    public const ATTRIBUTES = [
        'name'     => 'Charges',
        'role'     => 'manageJobs',
        'icon'     => 'fas fa-file-invoice-dollar',
        'category' => 'Assess',
        'summary'  => 'Staff reviews submission and sets charges',
        'header'   => 'Estimate Costs',
        'button'   => 'All Charges Added',
    ];

    /**
     * Creates an initial Estimate if Job does not have one.
     *
     * @param \App\Entities\Job $job
     */
    public static function up(Job $job): Job
    {
        if (! $job->getEstimate()) {
            model(LedgerModel::class)->insert([
                'job_id'   => $job->id,
                'estimate' => 1,
            ]);
        }

        return $job;
    }

    /**
     * Displays the form for modifying Charges
     * on the estimate Ledger.
     */
    public function get(): ResponseInterface
    {
        // Build out the clickable charge items for the "Details" aside
        $items = [];

        // Add print method base charge
        if (! empty($this->job->material)) {
            $items[] = [
                'name'     => $this->job->material->method->name,
                'quantity' => null,
                'amount'   => 0,
            ];

            // Add material volume estimation
            $items[] = [
                'name'     => $this->job->material->name,
                'quantity' => round($this->job->volume ?? 0, 1),
                'amount'   => price_to_scaled((int) $this->job->material->cost),
            ];
        }

        // Add items for each selected Option
        foreach ($this->job->options as $option) {
            $items[] = [
                'name'     => $option->summary,
                'quantity' => null,
                'amount'   => 0,
            ];
        }

        return $this->render('actions/charges', [
            'estimate' => $this->job->getEstimate(true),
            'items'    => $items,
        ]);
    }

    /**
     * Denotes that all Charges are created.
     *
     * @return null
     */
    public function post(): ?ResponseInterface
    {
        return null;
    }

    /**
     * Removes a single Charge.
     *
     * @return RedirectResponse
     */
    public function delete(): ResponseInterface
    {
        if ($chargeId = service('request')->getPost('charge_id')) {
            model(ChargeModel::class)->delete($chargeId);
            alert('warning', 'Charge removed.');
        }

        return redirect()->back();
    }

    /**
     * Adds a Charge to the estimate Ledger.
     *
     * @return RedirectResponse
     */
    public function put(): ResponseInterface
    {
        $data = service('request')->getPost();

        if (! isset($data['amount'])) {
            return redirect()->back()->withInput()->with('error', 'You must enter a price!');
        }

        // Convert the input into fractional money units
        $data['amount']    = scaled_to_price((float) $data['amount']);
        $data['ledger_id'] = $this->job->estimate->id;

        if (empty($data['quantity'])) {
            unset($data['quantity']);
        }

        // Add the Charge
        if (! model(ChargeModel::class)->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', model(ChargeModel::class)->errors()));
        }

        return redirect()->back();
    }
}
