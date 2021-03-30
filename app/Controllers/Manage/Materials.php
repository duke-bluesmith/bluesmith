<?php namespace App\Controllers\Manage;

use App\Models\MaterialModel;
use App\Models\MethodModel;
use CodeIgniter\HTTP\RedirectResponse;
use Tatter\Forms\Controllers\ResourcePresenter;

class Materials extends ResourcePresenter
{
	/**
	 * @var string  Name of the model for ResourcePresenter
	 */
	public $modelName = MaterialModel::class;

	/**
	 * @var MethodModel
	 */
	protected $methods;
	
    /**
     * Loads the Methods model.
     */
	public function __construct()
	{
		$this->methods = new MethodModel();
	}

    /**
     * Displays the form for a new Material.
     *
     * @return string
     */
	public function new(): string
	{
		$data = [
			'methodOptions' => $this->methodOptions()
		];
		
		helper('form');
		return $this->request->isAJAX()
			? view("{$this->names}/form", $data)
			: view("{$this->names}/new", $data);
	}

    /**
     * Lists materials for one method.
     *
     * @param string|null $methodId
     *
     * @return string|RedirectResponse
     */
	public function method(string $methodId = null)
	{
		$methods = new MethodModel();
		
		if (! $method = $methods->with('materials')->find($methodId))
		{
			$error = lang('Forms.notFound', ['method']);
			$this->alert('danger', $error);

			return redirect()->back()->withInput()->with('errors', [$error]);
		}
		
		return view('materials/method', ['method' => $method]);	
	}

    /**
     * Displays the form to edit a Material.
     *
     * @param mixed $id
     *
     * @return string|RedirectResponse
     */
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
		return $this->request->isAJAX()
			? view("{$this->names}/form", $data)
			: view("{$this->names}/edit", $data);
	}

    /**
     * Support function to load all Methods for select form.
     *
     * @return array
     */
	protected function methodOptions(): array
	{
		$methodOptions = [];

		foreach ($this->methods->with(false)->findAll() as $method)
		{
			$methodOptions[$method->id] = $method->name;
		}

		return $methodOptions;
	}
}
