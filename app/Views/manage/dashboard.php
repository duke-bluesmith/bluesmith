<?= $this->setVar('header', 'Notices')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<?php if ($notices === []): ?>

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
						<th scope="col">notice</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($notices as $notice): ?>

					<tr>
						<td>#<?= $notice->job_id ?></td>
						<td><?= anchor('manage/jobs/show/' . $notice->job_id, $notice->job_name) ?></td>
						<td><?= $notice->user_name ?></td>
						<td><?= $notice->status ?></td>
						<td data-order="<?= $notice->created_at->getTimestamp() ?>"><?= $notice->created_at->humanize() ?></td>
						<td><?= $notice->content ?></td>
					</tr>

					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
	</div>
</table>

<?php endif; ?>

<?= $this->endSection() ?>
