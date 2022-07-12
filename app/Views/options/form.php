
	<?= form_open(isset($option) ? "manage/options/update/{$option->id}" : 'manage/options') ?>

		<div class="form-group">
			<label for="name">Name</label>
			<input name="name" type="text" class="form-control" id="name" placeholder="Name" value="<?= set_value('name', $option->name ?? '') ?>">
		</div>

		<div class="form-group">
			<label for="summary">Summary</label>
			<input name="summary" type="text" class="form-control" id="summary" placeholder="Summary" value="<?= set_value('summary', $option->summary ?? '') ?>">
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea name="description" class="form-control" id="description" placeholder="description"><?= set_value('description', $option->description ?? '') ?></textarea>
		</div>

		<button class="btn btn-primary" type="submit"><?= isset($option) ? 'Update' : 'Create' ?></button>

	<?= form_close() ?>
