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
}
