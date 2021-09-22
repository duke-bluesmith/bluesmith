
	<?= form_open(isset($method) ? "manage/methods/{$method->id}" : 'manage/methods', ['onsubmit' => 'return desktopSubmit(this, closeModal);']) ?>

		<div class="form-group">
			<label for="name">Name</label>
			<input name="name" type="text" class="form-control" id="name" placeholder="Name" value="<?= set_value('name', $method->name ?? '') ?>">
		</div>

		<div class="form-group">
			<label for="summary">Summary</label>
			<input name="summary" type="text" class="form-control" id="summary" placeholder="Summary" value="<?= set_value('summary', $method->summary ?? '') ?>">
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea name="description" class="form-control" id="description" placeholder="description"><?= set_value('description', $method->description ?? '') ?></textarea>
		</div>

		<button class="btn btn-primary" type="submit"><?= isset($method) ? 'Update' : 'Create' ?></button>

	<?= form_close() ?>
