<?= $this->setVar('menu', $menu ?? '')->extend('templates/public') ?>
<?= $this->section('main') ?>

<div class="container">
	<div class="d-lg-none mb-3">
		<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
	</div>
	
	<div class="row">
		<div class="col-lg-9">
			<?= $content ?>
			<?php $methods = new \App\Models\MethodModel(); ?>
			<?php foreach ($methods->findAll() as $method): ?>
			<div class="border">
				
			</div>
			
			<?php endforeach; ?>
		</div>
		
		<div class="col-lg-3">
			<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
		</div>
	</div>
</div>

<?= $this->endSection() ?>
