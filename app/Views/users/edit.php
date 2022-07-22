<?php $this->extend(config('Layouts')->manage); ?>
<?php $this->section('main'); ?>

<div class="row">
	<div class="col-xl-3">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">User Details</h3>
			</div>
			<div class="card-body">
                <?= form_open('manage/users/update/' . $user->id) ?>

                    <div class="form-group">
                        <label for="firstname">First name</label>
                        <input name="firstname" type="text" class="form-control" id="firstname" placeholder="First name" value="<?= set_value('firstname', $user->firstname) ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label>
                        <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Last name" value="<?= set_value('lastname', $user->lastname) ?>">
                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>

                <?= form_close() ?>
			</div>
			<div class="card-body">
                <?= form_open('manage/users/credit/' . $user->id) ?>

                    <div class="form-group">
                        <label for="amount">Credit (cents)</label>
                        <input name="amount" type="number" class="form-control" id="amount" placeholder="Amount" value="<?= old('amount', 0) ?>">
                    </div>
            		<p><strong>Current Balance:</strong> <?= price_to_currency($user->balance) ?></p>

                    <button class="btn btn-primary" type="submit">Credit User</button>

                <?= form_close() ?>
			</div>
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
                <?= form_open('manage/users/ban/' . $user->id) ?>

                    <div class="form-group">
                        <label for="reason">Ban User</label>
                        <input name="reason" type="reason" class="form-control" id="reason" placeholder="Reason" value="<?= old('reason') ?>">
                    </div>
                    <button class="btn btn-danger" type="submit">Ban User</button>

                <?= form_close() ?>
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

<?php $this->endSection(); ?>
