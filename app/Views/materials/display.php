
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
			<a class="btn btn-primary" href="<?= site_url("manage/materials/edit/{$material->id}") ?>" onclick="return desktopModal('materials/edit/<?= $material->id ?>');">Edit</a>
			<a class="btn btn-link text-danger float-right" href="<?= site_url("manage/materials/remove/{$material->id}") ?>" onclick="return desktopModal('materials/remove/<?= $material->id ?>');">Delete</a>
		</div>
	</div>
