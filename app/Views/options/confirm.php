
	<ul>
		<li><strong>Name:</strong> <?= $option->name ?></li>
		<li><strong>Summary:</strong> <?= $option->summary ?></li>
	</ul>
	<p>Are you sure you want to remove this print option?</p>

	<?= form_open("manage/options/delete/{$option->id}") ?>

		<button class="btn btn-primary" type="submit">Confirm</button>
		<a class="btn btn-secondary" href="<?= site_url('manage/options') ?>">Cancel</a>

	<?= form_close() ?>
