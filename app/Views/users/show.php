<?= $this->setVar('menu', 'users')->setVar('header', 'User Details')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="row">
	<div class="col-xl-3">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title"><?= $user->getName() ?></h3>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><strong>First name:</strong> <?= $user->firstname ?></li>
				<li class="list-group-item"><strong>Last name:</strong> <?= $user->lastname ?></li>
				<li class="list-group-item"><strong>Balance:</strong> <?= price_to_currency($user->balance) ?></li>
				<li class="list-group-item"><strong>Status:</strong> <?= $user->status ?: '<em>None</em>' ?></li>
			</ul>

			<?php if (user()->isAdmin()): ?>
            <div class="card-body">
			    <a class="btn btn-info" href="<?= site_url('manage/users/impersonate/' . $user->id) ?>">Impersonate</a>
			</div>
			<?php endif; ?>
		</div>

    	<?php if (user()->isAdmin()): ?>
	
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

						<?php if (in_array($workflow->id, $userWorkflows, true)): ?>
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

		<?php endif; ?>

	</div>
	
   	<?php if (user()->isAdmin()): ?>

	<div class="col-xl-6">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">Access</h3>
			</div>
			<div class="card-body">
			    <h6>Groups</h6>
				<table class="table table-bordered">
 
					<?php $userGroups = array_column(model(GroupModel::class)->getGroupsForUser($user->id), 'group_id'); ?>
					<?php foreach ($groups as $group): ?>
					<tr>
						<td><?= $group->name ?></td>
						<td><?= $group->description ?></td>

						<?php if (in_array($group->id, $userGroups, true)): ?>
						<td><a class="btn btn-danger btn-sm" href="<?= site_url('manage/users/remove_group/' . $user->id . '/' . $group->id) ?>">Remove</a></td>
						<?php else: ?>
						<td><a class="btn btn-primary btn-sm" href="<?= site_url('manage/users/add_group/' . $user->id . '/' . $group->id) ?>">Add</a></td>
						<?php endif; ?>

					</tr>
					<?php endforeach; ?>

				</table>
			</div>
			<div class="card-body">
			    <h6>Permissions</h6>
			    <small class="text-muted">Permissions are inherited from a user's groups.</small>
				<table class="table table-bordered">
 
					<?php $userPermissions = model(PermissionModel::class)->getPermissionsForUser($user->id); ?>
					<?php foreach ($permissions as $permission): ?>
					<?php if (array_key_exists($permission->id, $userPermissions)): ?>
					<tr>
						<td><?= $permission->name ?></td>
						<td><?= $permission->description ?></td>
					</tr>
					<?php endif; ?>
					<?php endforeach; ?>

				</table>
			</div>
		</div>
	</div>

	<?php endif; ?>
</table>

<?= $this->endSection() ?>
