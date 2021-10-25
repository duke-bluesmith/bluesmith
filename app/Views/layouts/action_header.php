
	<?php if ($action->role === ''): ?>
	<h3><?= $action->name ?></h3>
	<?php endif; ?>

	<h4>for &ldquo;<?= $job->name ?>&rdquo;</h4>

	<!-- Step Wizard Bar -->
	<div id="wizard-wrapper" style="max-width: 1110px;">
		<?= \App\Libraries\Wizard::fromJob($job) ?>
	</div>

	<p><?= lang('Actions.' . $action->uid . 'Help') ?></p>

	<hr class="my-4">
