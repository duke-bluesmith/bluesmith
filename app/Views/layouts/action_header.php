
	<?php if ($action->role === ''): ?>
	<h3><?= $action->name ?></h3>
	<?php endif; ?>

	<h4>for &ldquo;<?= $job->name ?>&rdquo;</h4>

	<!-- Step Wizard Bar -->
	<div id="wizard-wrapper" style="max-width: 1110px;">
		<div class="d-flex justify-content-between py-3">
			<?php $after = false; ?>
			<?php foreach ($job->stages as $stage): ?>
			<?php $current = $stage->id === $job->stage->id; ?>
			<?php $bg      = $after ? 'secondary' : ($current ? 'success' : 'primary'); ?>
			<div class="wizard-stage">

				<?php if ($bg === 'primary' && $previous = $job->previous()): ?>
				<a href="<?= site_url($stage->action->getRoute($job->id)) ?>" onclick="return confirm('Are you sure you want to regress this job?');">
				<?php elseif ($bg === 'secondary' && ! $job->stage->required && ($next = $job->next()) && $next->id === $stage->id): ?>
				<a href="<?= site_url($next->action->getRoute($job->id)) ?>" onclick="return confirm('Are you sure you want to skip this stage?');">
				<?php else: ?>
				<a>
				<?php endif; ?>

					<div
						class="rounded-circle text-center text-white p-2 mr-1 h4 bg-<?= $bg ?> text-white"
						style="width: 45px; height: 45px;"
						data-toggle="tooltip"
						title="<?= $stage->action->summary ?>"
					>

						<i class="<?= $stage->action->icon ?>" ></i>
					</div>
				</a>
			</div>
			<?php $after = $after || $current; ?>
			<?php endforeach; ?>
		</div>
	</div>

	<p><?= lang('Actions.' . $action->uid . 'Help') ?></p>

	<hr class="my-4">
