<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<?= form_open('jobs/files/' . $job->id) ?>
	
		<input class="btn btn-primary float-md-right" type="submit" name="submit" value="<?= lang('Pub.saveContinue') ?>">	

		<button type="button" class="btn btn-primary float-md-right mr-2" data-toggle="modal" data-target="#dropzoneModal">
			<i class="fas fa-file-upload"></i> Add Files
		</button>
		
		<h2 class="my-4"><?= lang('Pub.files') ?></h2>
		<p><?= lang('Actions.filesHelp') ?></p>
		
		<div class="row">
			
			<div class="col">

				<?= view('Tatter\Files\Views\Formats\select', ['files' => $files, 'selected' => $job->relations('files', true)]) ?>
				
			</div>
		</div>
			
	<?= form_close() ?>

	<?= view('Tatter\Files\Views\Dropzone\modal') ?>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>
	
	<?= view(config('Files')->views['dropzone']) ?>

<?= $this->endSection() ?>
