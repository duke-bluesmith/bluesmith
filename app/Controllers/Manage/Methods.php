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
     * Displays the form to manage print Methods
     */
    public function index(): string
    {
        $methods = new MethodModel();

        return view('methods/index', [
            'methods' => $methods->with('materials')->findAll(),
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
