<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<?= form_open() ?>
	<?= $actionMenu ?>
	<?= form_close() ?>

	<h3>Charges</h3>

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

<?= $this->endSection() ?>
