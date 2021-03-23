<?= $this->setVar('menu', 'users')->setVar('header', 'User Details')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="row">
	<div class="col-xl-6">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title"><?= $user->getName() ?></h3>
			</div>
			<div class="card-body">
				<h6 class="card-subtitle mb-2 text-muted"><?= implode(', ', array_column($groups, 'name')) ?></h6>	
			</div>		
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><strong>First name:</strong> <?= $user->firstname ?></li>
				<li class="list-group-item"><strong>Last name:</strong> <?= $user->lastname ?></li>
				<li class="list-group-item"><strong>Balance:</strong> <?= price_to_currency($user->balance) ?></li>
				<li class="list-group-item"><strong>Status:</strong> <?= $user->status ?: '<em>None</em>' ?></li>
			</ul>
		</div>
	</div>
	<div class="col-xl-3">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">Workflows</h3>
			</div>
			<div class="card-body">
				<table class="table table-bordered">

					<?php $userWorkflows = array_column($user->getWorkflows(), 'id'); ?>
					<?php foreach ($workflows as $workflow): ?>
					<tr>
						<td><?= $workflow->name ?></td>

						<?php if (in_array($workflow->id, $userWorkflows)): ?>
						<td class="text-success"><?= $workflow->role ?: 'Open access' ?></td>
						<td><a class="btn btn-danger btn-sm" href="<?= site_url('manage/users/remove_workflow/' . $user->id . '/' . $workflow->id) ?>">Ban</a></td>

						<?php else: ?>

						<td class="text-danger"><?= $workflow->role ?: 'Banned' ?></td>
						<td><a class="btn btn-primary btn-sm" href="<?= site_url('manage/users/add_workflow/' . $user->id . '/' . $workflow->id) ?>">Allow</a></td>
						<?php endif; ?>

					</tr>
					<?php endforeach; ?>

				</table>
			</div>
		</div>
	</div>
</table>

<?= $this->endSection() ?>
