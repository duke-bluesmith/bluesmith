<?php

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\ProjectTestCase;

class PagesTest extends ProjectTestCase
{
	use DatabaseTestTrait, FeatureTestTrait;

	/**
	 * Should run db migration only once?
	 *
	 * @var boolean
	 */
	protected $migrateOnce = true;

	/**
	 * Should run seeding only once?
	 *
	 * @var boolean
	 */
	protected $seedOnce = true;

	/**
	 * Should the db be refreshed before test?
	 *
	 * @var boolean
	 */
	protected $refresh = false;

	public function testRootShowsHomePage()
	{
		$result = $this->get('/');

		$result->assertStatus(200);
		$result->assertSee('How it Works', 'h3');
	}

	public function testAboutOptions()
	{
		$result = $this->get('about/options');

		$result->assertStatus(200);
		$result->assertSee('Services and Pricing', 'h3');
	}

	public function testAboutTerms()
	{
		$result = $this->get('about/terms');

		$result->assertStatus(200);
		$result->assertSee('Contract of agreement', 'h3');
	}

	public function testAboutPrivacy()
	{
		$result = $this->get('about/privacy');

		$result->assertStatus(200);
		$result->assertSee('Sensitive jobs', 'h3');
	}

	public function testPageNotFound()
	{
		$this->expectException(PageNotFoundException::class);

		$result = $this->get('about/bananas');
	}
}
