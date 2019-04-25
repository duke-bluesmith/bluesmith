<?php namespace App\Database\Seeds;

use App\Models\StageModel;

class StagesSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		$stages = new StageModel();
		
		$rows = [
			[
				'type'        => 'define',
				'name'        => 'files',
				'uid'         => 'define.files',
				'party'       => 'client',
				'icon'        => 'fa-file-alt',
				'summary'     => 'Client selects or uploads files',
			],
			[
				'type'        => 'define',
				'name'        => 'assign',
				'uid'         => 'define.assign',
				'party'       => 'client',
				'icon'        => 'fa-user-friends',
				'summary'     => 'Client includes other clients',
			],
			[
				'type'        => 'define',
				'name'        => 'options',
				'uid'         => 'define.options',
				'party'       => 'client',
				'icon'        => 'fa-cogs',
				'summary'     => 'Client specifies method, materials, and options',
			],
			[
				'type'        => 'define',
				'name'        => 'terms',
				'uid'         => 'define.terms',
				'party'       => 'client',
				'icon'        => 'fa-tasks',
				'summary'     => 'Client accepts terms of service',
			],
			[
				'type'        => 'assess',
				'name'        => 'estimate',
				'uid'         => 'assess.estimate',
				'party'       => 'staff',
				'icon'        => 'fa-file-alt',
				'summary'     => 'Staff reviews submission and issues estimate',
			],
			[
				'type'        => 'assess',
				'name'        => 'approve',
				'uid'         => 'assess.approve',
				'party'       => 'client',
				'icon'        => 'fa-thumbs-up',
				'summary'     => 'Client approves estimate',
			],
			[
				'type'        => 'payment',
				'name'        => 'prepay',
				'uid'         => 'payment.prepay',
				'party'       => 'client',
				'icon'        => 'fa-comments-dollar',
				'summary'     => 'Client configures payment in advance',
			],
		];
	}
}
