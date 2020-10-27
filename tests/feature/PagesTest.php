<?php

use Tests\Support\FeatureTestCase;

class PagesTest extends FeatureTestCase
{
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
}

