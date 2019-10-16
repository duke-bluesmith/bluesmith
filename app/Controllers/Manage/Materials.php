<?php namespace App\Controllers\Manage;

use Tatter\Forms\Controllers\ResourcePresenter;
use App\Models\MethodModel;

class Materials extends ResourcePresenter
{
	public $modelName  = 'App\Models\MaterialModel';
	
	protected $helpers = ['alerts', 'assets', 'auth', 'inflector', 'themes'];
	protected $methods;
	
	public function __construct()
	{
		$this->methods = new MethodModel();
	}
	
	public function new()
	{
		$data = [
			'methodOptions' => $this->methodOptions()
		];
		
		helper('form');
		return $this->request->isAJAX() ?
			view("{$this->names}/form", $data) :
			view("{$this->names}/new", $data);
	}

	// List materials for one method
	public function method($methodId = null)
	{
		$methods = new MethodModel();
		
		if (! $method = $methods->find($methodId))
		{
			$error = lang('Forms.notFound', ['method']);
			$this->alert('danger', $error);

			return redirect()->back()->withInput()->with('errors', [$error]);
		}
		
		return view('materials/method', ['method' => $method]);	
	}
	
	public function edit($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof RedirectResponse)
		{
			return $object;
		}
		
		$data = [
			$this->name => $object,
			'methodOptions' => $this->methodOptions(),
		];

		helper('form');
		return $this->request->isAJAX() ?
			view("{$this->names}/form", $data) :
			view("{$this->names}/edit", $data);
	}
	
	// Support function to load form select-ready methods
	protected function methodOptions()
	{
		$methodOptions = [];
		
		foreach ($this->methods->with(false)->findAll() as $method)
		{
			$methodOptions[$method->id] = $method->name;
		}
		
		return $methodOptions;
	}
}
