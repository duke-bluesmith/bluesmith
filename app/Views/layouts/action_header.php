
	<?php if ($action::getAttributes()['role'] === ''): ?>
	<h3><?= $action::getAttributes()['name'] ?></h3>
	<?php endif; ?>

	<h4>for &ldquo;<?= $job->name ?>&rdquo;</h4>

	<!-- Step Wizard Bar -->
	<div id="wizard-wrapper" style="max-width: 1110px;">
		<?= \App\Libraries\Wizard::fromJob($job) ?>
	</div>

	<p><?= lang('Actions.' . $action::HANDLER_ID . 'Help') ?></p>

	<hr class="my-4">
