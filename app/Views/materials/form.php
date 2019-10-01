
	<?= form_open(isset($material) ? "manage/materials/{$material->id}" : 'manage/materials') ?>

		<div class="form-group">
			<label for="name">Name</label>
			<input name="name" type="text" class="form-control" id="name" placeholder="Name" value="<?= set_value('name', $material->name ?? '') ?>">
		</div>
		
		<div class="form-group">
			<label for="summary">Summary</label>
			<input name="summary" type="text" class="form-control" id="summary" placeholder="Summary" value="<?= set_value('summary', $material->summary ?? '') ?>">
		</div>
		
		<div class="form-group">
			<label for="description">Description</label>
			<textarea name="description" class="form-control" id="description" placeholder="description"><?= set_value('description', $material->description ?? '') ?></textarea>
		</div>
	
		<button class="btn btn-primary" type="submit"><?= isset($book) ? 'Update' : 'Create' ?></button>
	
	<?= form_close() ?>
