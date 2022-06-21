
	<ul>
		<li><strong>Name:</strong> <?= $material->name ?></li>
		<li><strong>Summary:</strong> <?= $material->summary ?></li>
	</ul>
	<p>Are you sure you want to remove this material?</p>

	<?= form_open("manage/materials/delete/{$material->id}") ?>

		<button class="btn btn-primary" type="submit">Confirm</button>
		<a class="btn btn-secondary" href="<?= site_url('manage/materials') ?>">Cancel</a>

	<?= form_close() ?>
