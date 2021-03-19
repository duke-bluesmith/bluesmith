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
	<div class="col-xl-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Eligible Workflows</h3>
			</div>
			<ul class="list-group list-group-flush">

				<?php foreach ($user->getWorkflows() as $workflow): ?>
				<li class="list-group-item"><?= $workflow->name ?></li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>
</table>

<?= $this->endSection() ?>
