<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">
	
	<?= form_open('jobs/clients/' . $job->id) ?>

		<input class="btn btn-primary float-md-right" type="submit" name="submit" value="<?= lang('Pub.saveContinue') ?>">	

	<?= form_close() ?>
	
	<h2 class="my-4"><?= lang('Pub.clients') ?></h2>
	<p><?= lang('Tasks.clientsHelp') ?></p>
		
	<div class="row">
		
		<div class="col-sm-6">
			<h3><?= lang('Tasks.addClients') ?></h3>

			<?= form_open('jobs/clients/' . $job->id, '', ['_method' => 'PUT']) ?>

				<div class="form-group">
					<label for="clientEmail">Email address</label>
					<input type="email" name="email" class="form-control" id="clientEmail" aria-describedby="emailHelp" placeholder="<?= lang('Pub.email') ?>...">
					<small id="emailHelp" class="form-text text-muted"><?= lang('Tasks.clientEmailHelp') ?></small>
				</div>

				<input class="btn btn-secondary" type="submit" name="submit" value="<?= lang('Pub.add') ?>">

			<?= form_close() ?>

		</div>

		<div class="col-sm-9 mt-5">
			<h3><?= lang('Tasks.currentClients') ?></h3>

			<?php if (empty($job->users)): ?>

			<p><em><?= lang('Tasks.noClients') ?></em></p>
				
			<?php else: ?>
				
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Client</th>
						<th scope="col">Email</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($job->users as $user): ?>

					<tr>
						<td><?= $user->firstname ?> <?= $user->lastname ?></td>
						<td><?= $user->email ?></td>
						<td>
							<?php if (count($job->users) > 1): ?>
							
							<?= form_open('jobs/clients/' . $job->id, '', ['_method' => 'DELETE']) ?>

								<input type="hidden" name="user_id" value="<?= $user->id ?>">
								<input class="btn btn-link btn-small" type="submit" name="remove" value="<?= lang('Pub.remove') ?>">	

							<?= form_close() ?>
							
							<?php endif; ?>
						</td>
					</tr>

					<?php endforeach; ?>

				</tbody>
			</table>

			<?php endif; ?>

		</div>

		<div class="col-sm-9 mt-5">
			<h3><?= lang('Tasks.pendingClients') ?></h3>

			<?php if (empty($job->invites)): ?>

			<p><em><?= lang('Tasks.noInvites') ?></em></p>
				
			<?php else: ?>
				
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Email</th>
						<th scope="col">Issued</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($job->invites as $invite): ?>

					<tr>
						<td><?= $invite->email ?></td>
						<td><?= $invite->created_at ?></td>
						<td>

							<?= form_open('jobs/clients/' . $job->id, '', ['_method' => 'DELETE']) ?>

								<input type="hidden" name="invite_id" value="<?= $invite->id ?>">
								<input class="btn btn-danger btn-small" type="submit" name="remove" value="<?= lang('Pub.remove') ?>">	

							<?= form_close() ?>

						</td>
					</tr>

					<?php endforeach; ?>

				</tbody>
			</table>

			<?php endif; ?>

		</div>
	</div>
</div>

<?= $this->endSection() ?>
