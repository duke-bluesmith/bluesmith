<?php

namespace App\Controllers\Manage;

use App\Models\OptionModel;
use Tatter\Forms\Controllers\ResourcePresenter;

class Options extends ResourcePresenter
{
    /**
     * @var string Name of the model for ResourcePresenter
     */
    public $modelName = OptionModel::class;

    /**
     * Displays the list of print Options
     */
    public function index(): string
    {
        if ($archive = $this->request->getGet('archive')) {
            $this->model->withDeleted()->where('deleted_at IS NOT NULL');
        }

        return view('options/index', [
            'options' => $this->model->findAll(),
            'archive' => $archive,
        ]);
    }
}
