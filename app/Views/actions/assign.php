<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>
	
	<?= form_open() ?>
	<?= $actionMenu ?>
	<?= form_close() ?>

	<p><?= lang('Actions.clientsHelp') ?></p>
		
	<div class="row">
		
		<div class="col-sm-6">
			<h3><?= lang('Actions.addClients') ?></h3>

			<?= form_open('jobs/clients/' . $job->id, '', ['_method' => 'PUT']) ?>

				<div class="form-group">
					<label for="clientEmail">Email address</label>
					<input type="email" name="email" class="form-control" id="clientEmail" aria-describedby="emailHelp" placeholder="<?= lang('Pub.email') ?>...">
					<small id="emailHelp" class="form-text text-muted"><?= lang('Actions.clientEmailHelp') ?></small>
				</div>

				<input class="btn btn-secondary" type="submit" name="submit" value="<?= lang('Pub.add') ?>">

			<?= form_close() ?>

		</div>

		<div class="col-sm-9 mt-5">
			<h3><?= lang('Actions.currentClients') ?></h3>

			<?php if (empty($job->users)): ?>
			<p><em><?= lang('Actions.noClients') ?></em></p>
			<?php else: ?>
			<?= view('clients/table', ['mayDelete' => true, 'users' => $job->users]) ?>
			<?php endif; ?>

		</div>

		<div class="col-sm-9 mt-5">
			<h3><?= lang('Actions.pendingClients') ?></h3>

			<?php if (empty($job->invites)): ?>

			<p><em><?= lang('Actions.noInvites') ?></em></p>
				
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

<?= $this->endSection() ?>
