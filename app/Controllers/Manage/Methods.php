<?php

namespace App\Controllers\Manage;

use App\Models\MethodModel;
use Tatter\Forms\Controllers\ResourcePresenter;

class Methods extends ResourcePresenter
{
    /**
     * @var string Name of the model for ResourcePresenter
     */
    public $modelName = MethodModel::class;

    /**
     * @var MethodModel|null
     */
    protected $model;

    /**
     * Displays the list of print Methods
     */
    public function index(): string
    {
        if ($archive = $this->request->getGet('archive')) {
            $this->model->withDeleted()->where('deleted_at IS NOT NULL');
        }

        return view('methods/index', [
            'methods' => $this->model->with('materials')->findAll(),
            'archive' => $archive,
        ]);
    }

    /**
     * Displays the form for a new Method
     */
    public function new(): string
    {
        helper('form');

        return $this->request->isAJAX()
            ? view('methods/form')
            : view('methods/new');
    }
}
