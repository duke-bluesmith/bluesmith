<?= $this->extend(config('Layouts')->manage) ?>
<?= $this->section('main') ?>

	<div class="row">
		<div class="col-sm-6">
			<h5>Print Details</h5>
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

			<h5>Job Summary</h5>
			<p><?= $job->summary ?></p>
		</div>

		<div class="col-sm-6">
			<h5>Estimated Charges</h5>

			<?php if (empty($estimate->charges)): ?>
			<p>No charges have been set.</p>
			<?php else: ?>
			<?= view('charges/table', ['mayDelete' => false, 'charges' => $estimate->charges]) ?>
			<?php endif; ?>

			<span class="float-right h5">Total: <?= $estimate->getTotal(true) ?></span>
		</div>
	</div>

	<?= form_open() ?>
		<input class="btn btn-success" type="submit" name="complete" value="<?= $buttonText ?>">
	<?= form_close() ?>

<?= $this->endSection() ?>
