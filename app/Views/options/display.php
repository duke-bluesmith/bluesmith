
	<div class="card shadow mb-4" style="min-width: 18rem; max-width: 24rem;">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><?= $option->name ?></h6>
		</div>
		<div class="card-body">
			<p><?= $option->summary ?></p>
			<p>
				<?= $option->description ?>
			</p>
		</div>
		<div class="card-footer">
			<a class="btn btn-primary" href="<?= site_url("manage/options/edit/{$option->id}") ?>">Edit</a>
			<a class="btn btn-link text-danger float-right" href="<?= site_url("manage/options/remove/{$option->id}") ?>">Delete</a>
		</div>
	</div>
