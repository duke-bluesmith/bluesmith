<?= $this->setVar('header', 'Notifications')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<?php if ($notifications === []): ?>

<p>Nothing needs attention!</p>

<?php else: ?>

<div class="card shadow mb-4">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th scope="col">Job ID</th>
						<th scope="col">Job Name</th>
						<th scope="col">Owner</th>
						<th scope="col">Status</th>
						<th scope="col">Time</th>
						<th scope="col">Notification</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($notifications as $notification): ?>

					<tr>
						<td>#<?= $notification->job_id ?></td>
						<td><?= anchor('manage/jobs/show/' . $notification->job_id, $notification->job_name) ?></td>
						<td><?= $notification->user_name ?></td>
						<td><?= $notification->status ?></td>
						<td data-order="<?= $notification->created_at->getTimestamp() ?>"><?= $notification->created_at->humanize() ?></td>
						<td><?= $notification->content ?></td>
					</tr>

					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
	</div>
</table>

<?php endif; ?>

<?= $this->endSection() ?>
