<?= $this->extend('layouts/manage') ?>
<?= $this->section('main') ?>

	<?= form_open() ?>
	<?= $actionMenu ?>
	<?= form_close() ?>

	<div class="row">
		<div class="col-sm-6">
			<h5>Details</h5>
			<table class="table">
				<tbody>

					<?php if ($job->material): ?>
					<tr>
						<th scope="row"><?= lang('Pub.printMethod') ?></th>
						<td><?= $job->material->method->name ?></td>
					</tr>
					<tr>
						<th scope="row"><?= lang('Pub.printMaterial') ?></th>
						<td><?= $job->material->name ?></td>
					</tr>
					<?php endif; ?>

					<?php foreach ($job->options as $option): ?>
					<tr>
						<th scope="row"><?= lang('Pub.jobOption') ?></th>
						<td><?= $option->summary ?></td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>
			<p><?= $job->summary ?></p>
		</div>

		<div class="col-sm-6">
			<h5>Charges</h5>

			<?php if (empty($estimate->charges)): ?>
			<p>No charges have been set.</p>
			<?php else: ?>
			<?= view('charges/table', ['mayDelete' => false, 'charges' => $estimate->charges]) ?>
			<?php endif; ?>

			<span class="float-right h5">Total: <?= $estimate->getTotal(true) ?></span>
		</div>
	</div>

<?= $this->endSection() ?>
