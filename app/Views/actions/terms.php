<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<div class="row">
		<div class="col">
			<?= $page->content ?? '<p>' . lang('Actions.genericTerms') . '</p>' ?>
		</div>
	</div>

	<?= form_open() ?>
		<div class="form-check">
			<input class="form-check-input" type="checkbox" value="1" id="acceptCheck" required>
			<label class="form-check-label" for="acceptCheck">
				I accept the terms.<span class="badge badge-warning ml-2">Required</span>
			</label>
		</div>
		<input class="btn btn-success" type="submit" name="complete" value="<?= $buttonText ?>">
	<?= form_close() ?>

<?= $this->endSection() ?>
