<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<div class="d-lg-none mb-3">
		<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
	</div>

	<div class="row">
		<div class="col-lg-9">

			<?= $content ?>

			<?php foreach (model('MethodModel')->findAll() as $method): ?>

			<div class="border p-3">
				<h4><?= $method->name ?></h4>
				<p class="small text-muted"><?= $method->summary ?></p>
				<p><?= nl2br($method->description) ?></p>

				<?php if ($materials = $method->materials): ?>

				<h5>Available Materials</h5>
				<ul>

				<?php foreach ($materials as $material): ?>
					<li><strong><?= $material->name ?>:</strong> <?= $material->summary ?></li>
				<?php endforeach; ?>

				</ul>

				<?php else: ?>
				<p><em>This print method has no available materials.</em></p>
				<?php endif; ?>
			</div>

			<?php endforeach; ?>

		</div>

		<div class="col-lg-3">
			<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
		</div>
	</div>

<?= $this->endSection() ?>
