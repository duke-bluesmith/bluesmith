<?= $this->setVar('menu', 'materials')->extend('templates/manage') ?>
<?= $this->section('main') ?>

<script src="<?= base_url('/assets/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Materials</h1>
<p class="mb-4">Available printing materials by method</p>

<!-- Content Row -->
<div class="row">

<?php if (empty($methods)): ?>

	<p>There are no defined print methods. Would you like to <a href="<?= site_url('manage/methods/new') ?>">add one now</a>?</p>

<?php else: ?>

	<div class="col-xl-4 col-lg-6">
	
	<?php foreach ($methods as $method): ?>
		
		<h1 class="h4 mb-0 text-gray-800"><?= $method->name ?></h1>

		<?php if (empty($method->materials)): dd($method);?>

		<p>This method has no defined materials. Would you like to <a href="<?= site_url('manage/materials/new/' . $method->id) ?>">add one now</a>?</p>

		<?php else: ?>
			<?php foreach ($method->materials as $material): ?>
		
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><?= $material->name ?></h6>
			</div>
			<div class="card-body">
				<form method="post" action="<?= site_url('manage/materials/' . $material->id) ?>">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= $material->name ?>">
					</div>
					
					<div class="form-group">
						<label for="summary">Summary</label>
						<input type="text" name="summary" class="form-control" id="name" placeholder="Summary" value="<?= $material->summary ?>">
					</div>
					
					<div class="form-group">
						<label for="description">Description</label>
						<textarea name="description" class="form-control" id="description" placeholder="description"><?= $material->description ?></textarea>
					</div>

					<button type="submit" class="btn btn-primary float-right">Submit</button>
				</form>
			</div>
		</div>
		
			<?php endforeach; ?>
		
		<hr />
		
		<?php endif; ?>
	
	<?php endforeach; ?>
	
    </div>

<?php endif; ?>

</div>

<?= $this->endSection() ?>
