<?php namespace ProjectTests\Support\Traits;

/**
 * Class FakerTrait
 *
 * A set of methods to be used for unit test cases to
 * assist with generating, creating, and removing faked data.
 */
trait FakerTrait
{
	/**
	 * Faker instance for generating content.
	 *
	 * @var Faker\Factory
	 */
	protected static $faker;

	/**
	 * Count of how many objects of each type have been created
	 *
	 * @var array of name => num
	 */
	protected $fakedCounts = [];

	/**
	 * Models to use for each obejct type
	 *
	 * @var array of name => class
	 */
	protected $fakerModels = [
		'User'     => 'App\Models\UserModel',
		'Job'      => 'App\Models\JobModel',
		'Stage'    => 'Tatter\Workflows\Models\StageModel',
		'Task'     => 'Tatter\Workflows\Models\TaskModel',
		'Workflow' => 'Tatter\Workflows\Models\WorkflowModel',
	];

    /**
     * Initialize Faker and make sure the object counts are clean
     */
	protected function fakerSetUp(): void
	{
		// Load Faker if it isn't already
		if (self::$faker === null)
		{
			self::$faker = \Faker\Factory::create();
		}

		// Make sure the counts are empty
		$this->fakedCounts = [];
	}

	/**
	 * Creates $num faked objects on-the-fly.
	 *
	 * @param string $name   Name of the object to match model & method
	 * @param int    $num    Number of objects to create
	 * @param array  $data   Array of data to override the random versions
	 *
	 * @return array  IDs of the new objects
	 */
	protected function createFaked(string $name, int $num = 1, array $data = [])
	{
		// Standardize the name
		$name = ucfirst(strtolower($name));

		// Get the generate method and the model
		$methodName = "generate{$name}";

		// Get the model
		$class = $this->fakerModels[$name];
		$model = new $class();

		$ids = [];
		for ($i = 0; $i < $num; $i++)
		{
			$row   = array_merge($this->$methodName(), $data);
			$ids[] = $model->insert($row);
		}

		if (empty($this->fakedCounts[$name]))
		{
			$this->fakedCounts[$name] = $num;
		}
		else
		{
			$this->fakedCounts[$name] += $num;
		}

		return $ids;
	}

	/**
	 * Generates random data to create a user
	 *
	 * @return array
	 */
	protected function generateUser(): array
	{
		$data = [
			'email'     => self::$faker->email,
			'username'  => self::$faker->userName,
			'firstname' => self::$faker->firstName,
			'lastname'  => self::$faker->lastName,
			'password'  => bin2hex(random_bytes(24)),
			'active'    => (bool) rand(0, 20),
		];

		// Run it through the entity to apply defaults, casts, and setters
		return (new \App\Entities\User($data))->toRawArray();
	}

	/**
	 * Generates random data to create a workflow
	 *
	 * @return array
	 */
	protected function generateWorkflow(): array
	{
		return [
			'name'        => self::$faker->word,
			'category'    => self::$faker->streetSuffix,
			'icon'        => self::$faker->safeColorName,
			'summary'     => self::$faker->sentence,
			'description' => self::$faker->paragraph,
		];
	}

	/**
	 * Generates random data to create a task
	 *
	 * @return array
	 */
	protected function generateTask(): array
	{
		$name = self::$faker->word;

		return [
			'category'    => self::$faker->streetSuffix,
			'name'        => ucfirst($name),
			'uid'         => strtolower($name),
			'class'       => implode('\\', array_map('ucfirst', self::$faker->words)),
			'role'        => rand(0, 2) ? 'user' : 'manageJobs',
			'icon'        => self::$faker->safeColorName,
			'summary'     => self::$faker->sentence,
			'description' => self::$faker->paragraph,
		];
	}

	/**
	 * Generates random data to create a stage
	 *
	 * @return array
	 */
	protected function generateStage(): array
	{
		return [
			'task_id'     => rand(1, $this->fakedCounts['Task']     ?? 12),
			'workflow_id' => rand(1, $this->fakedCounts['Workflow'] ?? 4),
			'required'    => (bool) rand(0, 5),
		];
	}

	/**
	 * Generates random data to create a job
	 *
	 * @return array
	 */
	protected function generateJob(): array
	{
		return [
			'name'        => self::$faker->catchPhrase,
			'summary'     => self::$faker->sentence,
			'workflow_id' => rand(1, $this->fakedCounts['Workflow'] ?? 4),
			'stage_id'    => rand(1, $this->fakedCounts['Stage']    ?? 99),
			'material_id' => rand(1, $this->fakedCounts['Material'] ?? 35),
		];
	}
}
