<?php

namespace App\Actions;

use App\BaseAction;
use App\Models\MethodModel;
use App\Models\OptionModel;
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
        'header'   => 'Select Options',
        'button'   => 'Options Selected',
    ];

    /**
     * Displays the options form.
     */
    public function get(): ResponseInterface
    {
        helper(['currency']);

        return $this->render('actions/options', [
            'methods' => model(MethodModel::class)->with('materials')->findAll(),
            'options' => model(OptionModel::class)->findAll(),
        ]);
    }

    /**
     * Processes form submission.
     *
     * @return null
     */
    public function post(): ?ResponseInterface
    {
        $data = service('request')->getPost();

        $this->jobs->update($this->job->id, [
            'material_id' => service('request')->getPost('material_id') ?: null,
        ]);

        if (is_array($options = service('request')->getPost('option_ids'))) {
            $this->job->setOptions($options);
        } else {
            $this->job->setOptions([]);
        }

        // End the action
        return null;
    }
}
