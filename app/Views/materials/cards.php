
<!-- Card deck -->
<div class="card-deck">

<?php foreach ($materials as $material): ?>
	
	<div class="card shadow mb-4" style="min-width: 18rem; max-width: 24rem;">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><?= $material->name ?></h6>
		</div>
		<div class="card-body">
			<p><?= $material->summary ?></p>
			<p>For <?= $material->method->name ?? 'undefined method' ?></p>
			<p>
				<?= $material->description ?>
			</p>
		</div>
		<div class="card-footer">
			<a href="#" class="btn btn-primary">Edit</a>
			<a href="#" class="btn btn-link text-danger float-right">Delete</a>
		</div>
	</div>
		
<?php endforeach; ?>

</div>