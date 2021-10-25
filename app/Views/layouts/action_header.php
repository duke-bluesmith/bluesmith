
	<?php if ($action->role === ''): ?>
	<a class="btn btn-info float-right" href="<?= site_url('jobs/show/' . $job->id) ?>">Job Details</a>
	<h3><?= $action->name ?></h3>
	<?php endif; ?>

	<h4>for &ldquo;<?= $job->name ?>&rdquo;</h4>

	<!-- Step Wizard Bar -->
	<div id="wizard-wrapper" style="max-width: 1110px;">
		<?= \App\Libraries\Wizard::fromJob($job) ?>
	</div>

	<p><?= lang('Actions.' . $action->uid . 'Help') ?></p>

	<hr class="my-4">
