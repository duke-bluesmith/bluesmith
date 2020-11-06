<?php namespace App\Database\Seeds;

use Tatter\Outbox\Database\Seeds\TemplateSeeder as BaseSeeder;
use Tatter\Outbox\Models\TemplateModel;

/**
 * Email Template Seeder
 *
 * Jump-starts Email Templates with some initial
 * values. These are likely to be changed later
 * via the Templates CRUD but this ensures that
 * every needed "name" is available and that
 * unit tests have comparable content available.
 *
 * Methodology: Starts with Outbox's seeder to
 * ensure a Default template is always available
 * (though this could be replaced with any template
 * named "Default"). Each defined Template will be
 * created as a child of Default.
 *
 * Note: Templates should *not* include inline CSS,
 * this is added later by Tatter\Outbox.
 */
class EmailSeeder extends BaseSeeder
{
	public function run()
	{
		// Run the module version first to ensure Default exists
		parent::run();

		// Use "Default" as the parent (will throw if it does not exist)
		$default = model(TemplateModel::class)->findByName('Default');

		// Define each Template
		$templates = [
			[
				'name'    => 'Job Invite',
				'subject' => lang('Invite.subject', ['{issuer_name}']),
				'body'    => view('emails/seeds/JobInvite'),
			],
		];

		foreach ($templates as $row)
		{
			if (model(TemplateModel::class)->where('name', $row['name'])->first())
			{
				continue;
			}

			// Set the parent
			$row['parent_id'] = $default->id;
			model(TemplateModel::class)->insert($row);
		}
	}
}
