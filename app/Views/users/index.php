<?= $this->setVar('menu', 'users')->setVar('header', 'Users')->extend(config('Layouts')->manage) ?>
<?= $this->section('main') ?>

<?php if (empty($rows)): ?>

<p>No users matched your request.</p>

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
						<th scope="col">Username</th>
						<th scope="col">First name</th>
						<th scope="col">Last name</th>
						<th scope="col">Group</th>
						<th scope="col">Balance</th>
						<th scope="col">Created</th>
						<th scope="col">Updated</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($rows as $row): ?>

					<tr>
						<td><?= $row['id'] ?></td>
						<td><?= anchor('manage/users/show/' . $row['id'], $row['username']) ?></td>
						<td><?= $row['firstname'] ?></td>
						<td><?= $row['lastname'] ?></td>
						<td><?= $row['group'] ?></td>
						<td><?= price_to_currency($row['balance']) ?></td>
						<td data-order="<?= $row['created_at']->getTimestamp() ?>"><?= $row['created_at']->format('n/j/Y') ?></td>
						<td data-order="<?= $row['updated_at']->getTimestamp() ?>"><?= $row['updated_at']->humanize() ?></td>
					</tr>

					<?php endforeach; ?>

				</tbody>
			</table>
		</div>
	</div>
</div>

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
