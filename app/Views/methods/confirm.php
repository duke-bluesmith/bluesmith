
	<ul>
		<li><strong>Name:</strong> <?= $method->name ?></li>
		<li><strong>Summary:</strong> <?= $method->summary ?></li>
	</ul>
	<p>Are you sure you want to remove this method?</p>

	<?= form_open("manage/methods/delete/{$method->id}") ?>

		<button class="btn btn-primary" type="submit">Confirm</button>
		<a class="btn btn-secondary" href="<?= site_url('manage/methods') ?>">Cancel</a>

	<?= form_close() ?>
