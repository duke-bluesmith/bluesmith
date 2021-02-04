<?= $this->setVar('menu', 'jobs')->setVar('header', 'Jobs')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<?php if (empty($rows)): ?>

<p>No jobs matched your request.</p>

<?php else: ?>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Name</th>
						<th scope="col">Owner</th>
						<th scope="col">Action</th>
						<th scope="col">Started</th>
						<th scope="col">Updated</th>
					</tr>
				</thead>
				<tbody>
	
					<?php foreach ($rows as $row): ?>

					<tr>
						<td><?= $row['id'] ?></td>
						<td><?= anchor('jobs/show/' . $row['id'], $row['name']) ?></td>
						<td><?= isset($row['user_id']) ? $row['firstname'] . ' ' . $row['lastname'] : '' ?></td>
						<td data-order="<?= $row['stage_id'] ?? 99 ?>"><?= $row['action'] ?? '<em>Complete</em>' ?></td>
						<td data-order="<?= $row['created_at']->getTimestamp() ?>"><?= $row['created_at']->format('n/j/Y') ?></td>
						<td data-order="<?= $row['updated_at']->getTimestamp() ?>"><?= $row['updated_at']->humanize() ?></td>
					</tr>
		
					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
	</div>
</table>

<?php endif; ?>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>
<script>
$(document).ready(function() {
	$('#dataTable').DataTable({
		"order": []
	});
});
</script>
<?= $this->endSection() ?>
