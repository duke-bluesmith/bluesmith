<?= $this->setVar('menu', 'methods')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<script src="<?= base_url('/assets/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Print Methods</h1>
<p class="mb-4">Available printing methods</p>

<?php if (empty($methods)): ?>

<p>There are no defined print methods. Would you like to <a href="<?= site_url('manage/methods/new') ?>">add one now</a>?</p>

<?php else: ?>
		
<!-- Card deck -->
<div class="card-deck">
	
	<?php foreach ($methods as $method): ?>
	
	<div class="card shadow mb-4" style="min-width: 24rem;">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><?= $method->name ?> <?= $method->summary && $method->name != $method->summary ? "({$method->summary})" : '' ?></h6>
		</div>
		<div class="card-body">
			<p><a class="btn btn-light" href="<?= site_url('manage/materials/method/' . $method->id) ?>"><?= counted(count($method->materials), 'materials') ?></a></p>
			<p>
				<?= $method->description ?>
			</p>
		</div>
		<div class="card-footer">
			<a href="#" class="btn btn-primary">Edit</a>
			<a href="#" class="btn btn-link text-danger float-right">Delete</a>
		</div>
	</div>
		
	<?php endforeach; ?>

</div>

<?php endif; ?>

<?= $this->endSection() ?>
