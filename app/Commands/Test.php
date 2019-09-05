<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Test extends BaseCommand
{
    protected $group       = 'Test';
    protected $name        = 'test';
    protected $description = 'Does various quick test functions.';

    public function run(array $params)
    {
    	$model = new \ProjectTests\Support\Models\ExampleModel();
//    	$model->first();
    	
    	$runner = service('migrations');
    	$runner->setNamespace('\ProjectTests\Support');
    	$migrations = $runner->findMigrations();
    	
    	var_dump($migrations);
	}
}