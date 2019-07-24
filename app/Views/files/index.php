<?= view('templates/header', ['menu' => 'files']) ?>

<div class="container">
	<div class="d-lg-none mb-3">
		<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="float-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dropzoneModal">
					<i class="fas fa-file-upload"></i> Add Files
				</button>
			</div>
			
			<h1>My Files</h1>

<?php if (empty($files)): ?>
			<p>
				You have no files! Would you like to
				<a class="dropzone-button" href="<?= site_url('files/new') ?>" data-toggle="modal" data-target="#dropzoneModal">add some now</a>?
			</p>

<?php else: ?>
			<ul>
	<?php foreach ($files as $file): ?>
				<li><?= $file->name ?></li>
	<?php endforeach; ?>
			</ul>
<?php endif; ?>
			
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="dropzoneModal" tabindex="-1" role="dialog" aria-labelledby="dropzoneModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dropzoneModalTitle">Add Files</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('files/upload') ?>" class="dropzone" id="files-dropzone"></form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?= view('templates/footer') ?>
