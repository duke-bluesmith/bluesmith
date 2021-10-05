<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<?= form_open() ?>

		<button type="button" class="btn btn-primary float-md-right mr-2" data-toggle="modal" data-target="#dropzoneModal">
			<i class="fas fa-file-upload"></i> Add Files
		</button>

		<div class="row">
			<div class="col">

				<?= view('Tatter\Files\Views\Formats\select', ['files' => $files, 'selected' => $job->relations('files', true)]) ?>

			</div>
		</div>

		<input class="btn btn-success" type="submit" name="complete" value="<?= $buttonText ?>">

	<?= form_close() ?>

	<?= view('Tatter\Files\Views\Dropzone\modal') ?>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>

	<?= view(config('Files')->views['dropzone']) ?>

<?= $this->endSection() ?>
