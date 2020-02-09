<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<a class="btn btn-primary float-md-right" href="<?= site_url(config('Workflows')->routeBase . '/' . $job->id) ?>">Continue Job</a>

	<div class="row my-3">
		<div class="col-sm-8">
			<h2><?= $job->name ?></h2>
			<p><?= $job->summary ?></p>

			<?php if ($job->material): ?>

			<div class="card">
				<div class="card-header"><?= lang('Pub.printMethodAndMaterials') ?></div>
				<div class="card-body">
					<h5 class="card-title"><?= $job->material->method->name ?></h5>
					<p class="card-text"><?= $job->material->method->summary ?></p>
				</div>
				<div class="card-body">
					<h5 class="card-title"><?= $job->material->name ?></h5>
					<p class="card-text"><?= $job->material->summary ?></p>

					<a href="#" class="card-link">Change</a>
				</div>
			</div>

			<?php endif; ?>

		</div>

		<div class="col-sm-4">

			<?php helper('chat'); ?>
			<?= chat('job-' . $job->id) ?>

		</div>
	</div>

<?= $this->endSection() ?>
