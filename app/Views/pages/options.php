<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<div class="d-lg-none mb-3">
		<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
	</div>
	
	<div class="row">
		<div class="col-lg-9">

			<?= $content ?>

			<?php foreach ((new \App\Models\MethodModel())->findAll() as $method): ?>

			<div class="border">
				<h5><?= $method->name ?></h5>
			</div>
			
			<?php endforeach; ?>

		</div>
		
		<div class="col-lg-3">
			<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
		</div>
	</div>

<?= $this->endSection() ?>
