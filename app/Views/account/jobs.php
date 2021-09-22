<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<div class="d-lg-none mb-3">
		<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
	</div>

	<div class="row">
		<div class="col-lg-9">
			<h3>Your jobs</h3>

			<?php if (empty($jobs)): ?>

			<p>
				You don't have any jobs! Would you like to
				<a href="<?= site_url('jobs/new') ?>">submit one</a>?
			</p>

			<?php else: ?>

			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Job</th>
						<th>Status</th>
						<th>Submitted</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($jobs as $job): ?>

					<tr>
						<td><?= $job->id ?></td>
						<td><a href="<?= site_url('jobs/show/' . $job->id) ?>"><?= $job->name ?></a></td>
						<td><?= $job->getStage() ? $job->stage->name : '<em>Complete</em>' ?></td>
						<td><?= $job->created_at->humanize() ?></td>

				<?php endforeach; ?>

			</table>

			<?php endif; ?>

		</div>

		<div class="col-lg-3">
			<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
		</div>
	</div>

<?= $this->endSection() ?>
