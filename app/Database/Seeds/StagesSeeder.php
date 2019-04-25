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
				'route'       => 'files',
				'party'       => 'client',
				'icon'        => 'fa-file-alt',
				'summary'     => 'Client selects or uploads files',
			],
			[
				'type'        => 'define',
				'name'        => 'assign',
				'uid'         => 'define.assign',
				'route'       => 'clients',
				'party'       => 'client',
				'icon'        => 'fa-user-friends',
				'summary'     => 'Client includes other clients',
			],
			[
				'type'        => 'define',
				'name'        => 'options',
				'uid'         => 'define.options',
				'route'       => 'edit',
				'party'       => 'client',
				'icon'        => 'fa-cogs',
				'summary'     => 'Client specifies method, materials, and options',
			],
			[
				'type'        => 'define',
				'name'        => 'prepay',
				'uid'         => 'define.prepay',
				'route'       => 'prepay',
				'party'       => 'client',
				'icon'        => 'fa-comments-dollar',
				'summary'     => 'Client submits payment in advance',
			],
			[
				'type'        => 'define',
				'name'        => 'terms',
				'uid'         => 'define.terms',
				'route'       => 'terms',
				'party'       => 'client',
				'icon'        => 'fa-tasks',
				'summary'     => 'Client accepts terms of service',
			],
			[
				'type'        => 'assess',
				'name'        => 'charges',
				'uid'         => 'assess.charges',
				'route'       => 'charges',
				'party'       => 'staff',
				'icon'        => 'fa-file-invoice-dollar',
				'summary'     => 'Staff reviews submission and sets charges',
			],
			[
				'type'        => 'assess',
				'name'        => 'estimate',
				'uid'         => 'assess.estimate',
				'route'       => 'estimate',
				'party'       => 'staff',
				'icon'        => 'fa-file-alt',
				'summary'     => 'Staff issues estimate',
			],
			[
				'type'        => 'assess',
				'name'        => 'approve',
				'uid'         => 'assess.approve',
				'route'       => 'approve',
				'party'       => 'client',
				'icon'        => 'fa-thumbs-up',
				'summary'     => 'Client approves estimate',
			],
			[
				'type'        => 'process',
				'name'        => 'print',
				'uid'         => 'process.print',
				'route'       => 'print',
				'party'       => 'staff',
				'icon'        => 'fa-cubes',
				'summary'     => 'Staff prints objects',
			],
			[
				'type'        => 'process',
				'name'        => 'postprint',
				'uid'         => 'process.postprint',
				'route'       => 'postprint',
				'party'       => 'staff',
				'icon'        => 'fa-broom',
				'summary'     => 'Staff post-processes objects',
			],
			[
				'type'        => 'complete',
				'name'        => 'payment',
				'uid'         => 'complete.payment',
				'route'       => 'payment',
				'party'       => 'client',
				'icon'        => 'fa-money-check',
				'summary'     => 'Client submits payment for charges',
			],
			[
				'type'        => 'complete',
				'name'        => 'deliver',
				'uid'         => 'complete.deliver',
				'route'       => 'deliver',
				'party'       => 'staff',
				'icon'        => 'fa-truck',
				'summary'     => 'Staff delivers objects to client',
			],
		];
	}
}
