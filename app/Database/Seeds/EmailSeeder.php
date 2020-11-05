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
 * created as a child of Default, with its own
 * tokens merged to its parent's.
 *
 * Note: Templates should *not* include CSS, this
 * is inlined later by Tatter\Outbox.
 */
class EmailSeeder extends BaseSeeder
{
	public function run()
	{
		// Run the module version first to ensure Default exists
		parent::run();

		// Always start with the Default Template (will throw if it does not exist)
		$default = model(TemplateModel::class)->findByName('Default');

		// Fill the common tokens
		$body = service('parser')->setData([
			'contact'     => service('settings')->orgName,
			'unsubscribe' => anchor(route_to('unsubscribe'), 'Unsubscribe'),
		], 'raw')->renderString($default->body, ['debug' => false]);

		if ($body !== $default->body)
		{
			// Remove any tokens that were filled
			$tokens = array_diff($default->tokens, ['contact', 'unsubscribe']);
			model(TemplateModel::class)->update($default->id, [
				'body'   => $body,
				'tokens' => implode(',', $tokens),
			]);

			// Reload the Template
			$default = model(TemplateModel::class)->findByName('Default');
		}

		// Define each Template
		$templates = [
			[
				'name'    => 'Job Invite',
				'subject' => lang('Invite.subject', ['{issuer_name}']),
				'body'    => view('emails/seeds/JobInvite'),
				'tokens'  => 'issuer_name,accept_url',
			],
		];

		// Remove {body} from the list of tokens
		$tokens = $default->tokens;
		unset($tokens[array_search('body', $tokens)]);

		foreach ($templates as $row)
		{
			if (model(TemplateModel::class)->where('name', $row['name'])->first())
			{
				continue;
			}

			// Set the parent
			$row['parent_id'] = $default->id;

			// Merge the tokens
			$row['tokens'] = implode(',',
				array_unique(
					array_merge(
						explode(',', $row['tokens']),
					$tokens)
				)
			);

			model(TemplateModel::class)->insert($row);
		}
	}
}
