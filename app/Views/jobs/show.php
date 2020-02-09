<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<a class="btn btn-primary float-md-right mb-3" href="<?= site_url(config('Workflows')->routeBase . '/' . $job->id) ?>">Continue Job</a>

	<h2><?= $job->name ?></h2>

	<div class="row">
		<div class="col-sm-8">
			<p><?= $job->summary ?></p>

			<?php if ($job->material): ?>

			<h4><?= lang('Pub.printMethodAndMaterials') ?></h4>
			<table class="table">
				<tr>
					<th scope="row"><?= lang('Pub.printMethod') ?></th>
					<td><?= $job->material->method->name ?></td>
				</tr>
				<tr>
					<th scope="row"><?= lang('Pub.printMaterial') ?></th>
					<td><?= $job->material->name ?></td>
				</tr>
			</table>

			<a href="#" class="btn btn-secondary">Change</a>

			<?php endif; ?>

		</div>

		<div class="col-sm-4">

			<?php helper('chat'); ?>
			<?= chat('job-' . $job->id, 'Staff support') ?>

		</div>
	</div>

	<div class="row my-3">
		<div class="col-sm-4">
			<h3>Progress</h3>

			<?php foreach ($job->stages as $stage): ?>
			
			<p><?= print_r($stage, true) ?></p>

			<?php endforeach; ?>
			
		</div>
	</div>

<?= $this->endSection() ?>
