<?php namespace Tests\Support;

use App\Entities\Job;
use App\Models\JobModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Test\FeatureResponse;
use Tatter\Workflows\Entities\Action;
use RuntimeException;

/**
 * Action Test Trait
 *
 * Support components for testing Actions.
 *
 * @property string $actionUid The Action to test. Must be set by child class.
 */
trait ActionTrait
{
	/**
	 * @var Action
	 */
	protected $action;

	/**
	 * @var Job
	 */
	protected $job;

	/**
	 * Fakes a Job and initializes the Action identified by $actionUid
	 *
	 * @return void
	 */
	protected function setUpActionTrait(): void
	{
		// Make sure the helper is loaded
		if (! function_exists('handlers'))
		{
			helper('handlers');
		}

		// Create a random Job for the Action
		$this->job = fake(JobModel::class);

		// Locate the Action based on its UID
		if (! $class = handlers('Actions')->find($this->actionUid))
		{
			throw new RuntimeException('Unable to locate an Action for ' . $this->actionUid);
		}

		// Create the Action
		$this->action = new $class($this->job);
	}

    /**
     * Calls an Action method expected to return `null`.
     *
     * @param string $method
     *
     * @return void
     */
	protected function expectNull(string $method): void
	{
		$result = $this->action->$method();

		$this->assertNull($result);
	}

    /**
     * Calls an Action method expected to return
     * a display response (i.e. not a redirect).
     *
     * @param string $method
     *
     * @return FeatureResponse
     */
	protected function expectResponse(string $method): FeatureResponse
	{
		return $this->getResponse($method, false);
	}

    /**
     * Calls an Action method expected to return
     * a display response (i.e. not a redirect).
     *
     * @param string $method
     *
     * @return FeatureResponse
     */
	protected function expectRedirect(string $method): FeatureResponse
	{
		return $this->getResponse($method, true);
	}

    /**
     * Calls an Action method expected to return
     * a `ResponseInterface`, verifies it, and returns
     * the response wrapped in a FeatureResponse.
     *
     * @param string $method The Action method to call
     * @param bool $redirect Whether to expect a redirect
     *
     * @return FeatureResponse
     */
	private function getResponse(string $method, bool $redirect): FeatureResponse
	{
		$result = $this->action->$method();
		$this->assertInstanceOf(ResponseInterface::class, $result);

		$response = new FeatureResponse($result);
		$response->assertOK();

		$this->assertEquals($redirect, $response->isRedirect());

		return $response;
	}
}
