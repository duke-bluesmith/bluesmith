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
				'route'       => 'jobs/files',
				'party'       => 'client',
				'icon'        => 'fa-file-alt',
				'summary'     => 'Client selects or uploads files',
			],
			[
				'type'        => 'define',
				'name'        => 'assign',
				'uid'         => 'define.assign',
				'route'       => 'jobs/clients',
				'party'       => 'client',
				'icon'        => 'fa-user-friends',
				'summary'     => 'Client includes other clients',
			],
			[
				'type'        => 'define',
				'name'        => 'options',
				'uid'         => 'define.options',
				'route'       => 'jobs/edit',
				'party'       => 'client',
				'icon'        => 'fa-cogs',
				'summary'     => 'Client specifies method, materials, and options',
			],
			[
				'type'        => 'define',
				'name'        => 'prepay',
				'uid'         => 'define.prepay',
				'route'       => 'jobs/prepay',
				'party'       => 'client',
				'icon'        => 'fa-comments-dollar',
				'summary'     => 'Client submits payment in advance',
			],
			[
				'type'        => 'define',
				'name'        => 'terms',
				'uid'         => 'define.terms',
				'route'       => 'jobs/terms',
				'party'       => 'client',
				'icon'        => 'fa-tasks',
				'summary'     => 'Client accepts terms of service',
			],
			[
				'type'        => 'assess',
				'name'        => 'charges',
				'uid'         => 'assess.charges',
				'route'       => 'jobs/charges',
				'party'       => 'staff',
				'icon'        => 'fa-file-invoice-dollar',
				'summary'     => 'Staff reviews submission and sets charges',
			],
			[
				'type'        => 'assess',
				'name'        => 'estimate',
				'uid'         => 'assess.estimate',
				'route'       => 'jobs/estimate',
				'party'       => 'staff',
				'icon'        => 'fa-file-alt',
				'summary'     => 'Staff issues estimate',
			],
			[
				'type'        => 'assess',
				'name'        => 'approve',
				'uid'         => 'assess.approve',
				'route'       => 'jobs/approve',
				'party'       => 'client',
				'icon'        => 'fa-thumbs-up',
				'summary'     => 'Client approves estimate',
			],
			[
				'type'        => 'process',
				'name'        => 'print',
				'uid'         => 'process.print',
				'route'       => 'jobs/print',
				'party'       => 'staff',
				'icon'        => 'fa-cubes',
				'summary'     => 'Staff prints objects',
			],
			[
				'type'        => 'process',
				'name'        => 'postprint',
				'uid'         => 'process.postprint',
				'route'       => 'jobs/postprint',
				'party'       => 'staff',
				'icon'        => 'fa-broom',
				'summary'     => 'Staff cleans and post-processes objects',
			],
			[
				'type'        => 'complete',
				'name'        => 'payment',
				'uid'         => 'complete.payment',
				'route'       => 'jobs/payment',
				'party'       => 'client',
				'icon'        => 'fa-money-check',
				'summary'     => 'Client submits payment for charges',
			],
			[
				'type'        => 'complete',
				'name'        => 'deliver',
				'uid'         => 'complete.deliver',
				'route'       => 'jobs/deliver',
				'party'       => 'staff',
				'icon'        => 'fa-truck',
				'summary'     => 'Staff delivers object to client',
			],
		];
	}
}
