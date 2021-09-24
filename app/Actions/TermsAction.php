<?php

namespace App\Actions;

use App\BaseAction;
use App\Models\PageModel;
use CodeIgniter\HTTP\ResponseInterface;

class TermsAction extends BaseAction
{
    /**
     * @var array<string, string>
     */
    public $attributes = [
        'category' => 'Define',
        'name'     => 'Terms',
        'uid'      => 'terms',
        'role'     => '',
        'icon'     => 'fas fa-actions',
        'summary'  => 'Client accepts terms of service',
        'header'   => 'Terms of Service',
        'button'   => 'Accept the Terms',
    ];

    public function get(): ResponseInterface
    {
        return $this->render('actions/terms', [
            'job'  => $this->job,
            'page' => model(PageModel::class)->where('name', 'Terms')->first(),
        ]);
    }

    public function post(): ?ResponseInterface
    {
        $data = service('request')->getPost();

        if (empty($data['complete'])) {
            alert('warning', lang('Actions.mustAccept'));

            return redirect()->back();
        }

        $this->job->setFlag('Accepted');

        // End the action
        return null;
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
