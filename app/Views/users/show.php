<?php $this->extend(config('Layouts')->manage); ?>
<?php $this->section('main'); ?>

<div class="row">
	<div class="col-xl-3">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title"><?= $user->getName() ?></h3>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><strong>Username:</strong> <?= $user->username ?></li>
				<li class="list-group-item"><strong>First name:</strong> <?= $user->firstname ?></li>
				<li class="list-group-item"><strong>Last name:</strong> <?= $user->lastname ?></li>
				<li class="list-group-item"><strong>Email:</strong> <?= $user->email ?></li>
				<li class="list-group-item"><strong>Groups:</strong>  <?= implode(', ', array_column($groups, 'name')) ?></li>
				<li class="list-group-item"><strong>Status:</strong> <?= $user->status ?: '<em>None</em>' ?></li>
				<li class="list-group-item"><strong>Balance:</strong> <?= price_to_currency($user->balance) ?></li>
			</ul>

			<?php if (user()->isAdmin()): ?>
            <div class="card-body">
			    <a class="btn btn-primary" href="<?= site_url('manage/users/edit/' . $user->id) ?>">Edit User</a>
			    <a class="btn btn-info float-right" href="<?= site_url('manage/users/impersonate/' . $user->id) ?>">Impersonate</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</table>

<?php $this->endSection(); ?>
