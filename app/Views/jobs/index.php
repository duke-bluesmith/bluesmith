<?= $this->setVar('menu', 'jobs')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Jobs</h1>
<p class="mb-4">Browse and manage jobs</p>

<?php if (empty($jobs)): ?>

<p>No jobs matched your request.</p>

<?php else: ?>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Active jobs</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Name</th>
						<th scope="col">Owner</th>
						<th scope="col">Workflow</th>
						<th scope="col">Action</th>
						<th scope="col">Start date</th>
					</tr>
				</thead>
				<tbody>
	
					<?php foreach ($jobs as $job): ?>

					<tr>
						<td><?= $job->id ?></td>
						<td><?= anchor('jobs/show/' . $job->id, $job->name) ?></td>
						<td><?= 'Jill User' ?></td>
						<td><?= $job->workflow->name ?></td>
						<td><?= $job->stage->name ?></td>
						<td><?= $job->created_at->humanize() ?></td>
					</tr>
		
					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
	</div>
</table>

<?php endif; ?>

<?= $this->endSection() ?>
