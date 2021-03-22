<?= $this->setVar('menu', 'users')->setVar('header', 'User Details')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="row">
	<div class="col-xl-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?= $user->getName() ?></h3>
			</div>
			<div class="card-body">
				<h6 class="card-subtitle mb-2 text-muted"><?= implode(', ', array_column($groups, 'name')) ?></h6>	
			</div>		
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><strong>First name:</strong> <?= $user->lastname ?></li>
				<li class="list-group-item"><strong>Last name:</strong> <?= $user->firstname ?></li>
				<li class="list-group-item"><strong>Balance:</strong> <?= price_to_currency($user->balance) ?></li>
				<li class="list-group-item"><strong>Status:</strong> <?= $user->status ?: '<em>None</em>' ?></li>
			</ul>
		</div>
	</div>
	<div class="col-xl-3">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title">Allowed Workflows</h3>
			</div>
			<ul class="list-group list-group-flush">

				<?php $userWorkflows = []; ?>
				<?php foreach ($user->getWorkflows() as $workflow): $userWorkflows[] = $workflow->id; ?>
				<li class="list-group-item">
					<?= $workflow->name ?>
					<a href="<?= site_url('manage/users/remove_workflow/' . $user->id . '/' . $workflow->id) ?>" class="badge badge-danger text-white float-right">Restrict</a>
				</li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>
	<div class="col-xl-3">
		<div class="card card-outline card-danger">
			<div class="card-header">
				<h3 class="card-title">Restriced Workflows</h3>
			</div>
			<ul class="list-group list-group-flush">

				<?php foreach ($workflows as $workflow): ?>
				<?php if (in_array($workflow->id, $userWorkflows)): continue; endif; ?>
				<li class="list-group-item">
					<?= $workflow->name ?>
					<a href="<?= site_url('manage/users/add_workflow/' . $user->id . '/' . $workflow->id) ?>" class="badge badge-primary text-white float-right">Allow</a>
				</li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>
</table>

<?= $this->endSection() ?>
