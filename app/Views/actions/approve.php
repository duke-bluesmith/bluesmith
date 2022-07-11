<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<h3>Charges</h3>
	<div class="row">
		<div class="col-sm-8">
			<?php if (empty($estimate->charges)): ?>
			<p class="text-danger">No charges have been set.</p>
			<?php else: ?>
			<?= view('charges/table', ['mayDelete' => false, 'charges' => $estimate->charges]) ?>
			<?php endif; ?>
			<span class="float-right h3">Total: <?= $estimate->getTotal(true) ?></span>

			<h3>Additional Notes</h3>
			<blockquote>
			<?= nl2br($job->estimate->description ?: '<em>Nothing noted.</em>') ?>
			</blockquote>

			<?= form_open() ?>
				<div class="form-check mb-3">
					<input class="form-check-input" type="checkbox" value="" id="approveCheck" required>
					<label class="form-check-label font-weight-bold font-italic" for="approveCheck">
						I approve the estimated charges.
					</label>
				</div>
				<input class="btn btn-success" type="submit" name="complete" value="<?= $buttonText ?>">
			<?= form_close() ?>
		</div>
		<div class="col-sm-4">

			<?= chat('job-' . $job->id, 'Staff support') ?>

		</div>
	</div>

<?= $this->endSection() ?>
