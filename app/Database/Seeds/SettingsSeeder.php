<?php namespace App\Database\Seeds;

use Tatter\Settings\Models\SettingModel;

class SettingsSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		// Define the settings necessary to this project
		$rows = [
			[
				'name'       => 'theme',
				'scope'      => 'user',
				'content'    => '1',
				'protected'  => 0,
				'summary'    => 'Site display theme',
			],
			[
				'name'       => 'orgName',
				'scope'      => 'global',
				'content'    => 'Organization',
				'protected'  => 1,
				'summary'    => 'Your organization name',
			],
			[
				'name'       => 'orgLogo',
				'scope'      => 'global',
				'content'    => '/assets/images/logo.png',
				'protected'  => 1,
				'summary'    => 'Your organization logo',
			],
			[
				'name'       => 'orgUrl',
				'scope'      => 'global',
				'content'    => 'https://example.com',
				'protected'  => 1,
				'summary'    => 'Your organization URL',
			],
			[
				'name'       => 'orgAddress',
				'scope'      => 'global',
				'content'    => '4141 Postmark Dr  Anchorage, AK',
				'protected'  => 1,
				'summary'    => 'Your organization address',
			],
			[
				'name'       => 'orgPhone',
				'scope'      => 'global',
				'content'    => '(951) 262-3062',
				'protected'  => 1,
				'summary'    => 'Your organization phone',
			],
			[
				'name'       => 'brandName',
				'scope'      => 'global',
				'content'    => 'Bluesmith',
				'protected'  => 1,
				'summary'    => 'Brand name for this project',
			],
			[
				'name'       => 'brandLogo',
				'scope'      => 'global',
				'content'    => '/assets/images/logo.png',
				'protected'  => 1,
				'summary'    => 'Brand logo for this project',
			],
		];
		
		// Check for and create necessary project settings
		$settings = new SettingModel();
		foreach ($rows as $row)
		{
			$setting = $settings->where('name', $row['name'])->first();
			
			if (empty($setting))
			{
				// No setting - add the row
				$settings->insert($row);
			}
		}
	}
}