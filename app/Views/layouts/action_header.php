	<!-- Step Wizard Bar -->
	<div id="wizard-wrapper" class="mb-3">
		<h5>Job Progress</h5>
		<div class="d-flex justify-content-between py-3">
			<?php $after = false; ?>
			<?php foreach ($job->stages as $stage): ?>
			<?php $current = $stage->id === $job->stage->id; ?>
			<?php $bg      = $after ? 'secondary' : ($current ? 'success' : 'primary'); ?>
			<div class="wizard-stage">
				<div
					class="rounded-circle text-center p-2 mr-1 h4 bg-<?= $bg ?> text-white"
					style="width: 45px; height: 45px;"
					data-toggle="tooltip"
					title="<?= $stage->action->summary ?>"
				>
					<?php if ($bg === 'primary' && $previous = $job->previous()): ?>
					<a class="text-white" href="<?= site_url($stage->action->getRoute($job->id)) ?>" onclick="return confirm('Are you sure you want to regress this job?');">
					<?php elseif ($bg === 'secondary' && ! $job->stage->required && ($next = $job->next()) && $next->id === $stage->id): ?>
					<a class="text-white" href="<?= site_url($next->action->getRoute($job->id)) ?>" onclick="return confirm('Are you sure you want to skip this stage?');">
					<?php else: ?>
					<a class="text-white">
					<?php endif; ?>

					<i class="<?= $stage->action->icon ?>" ></i>
					</a>
				</div>
			</div>
			<?php $after = $after || $current; ?>
			<?php endforeach; ?>
		</div>
	</div>

	<h3><?= $action->name ?> Stage</h3>
	<h4>for &ldquo;<?= $job->name ?>&rdquo;</h4>
	<p><?= lang('Actions.' . $action->uid . 'Help') ?></p>

	<hr>
