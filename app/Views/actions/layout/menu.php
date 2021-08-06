
	<input class="btn btn-success float-md-right" type="submit" name="complete" value="<?= $action->button ?>">

	<?php if (! $action->job->stage->required && $stage = $action->job->next()): ?>
	<a class="btn btn-link float-right" href="<?= site_url($stage->action->getRoute($action->job->id)) ?>" role="button" onclick="return confirm('Are you sure you want to skip this stage?');">
		<i class="fas fa-arrow-circle-right"></i> <?= $stage->name ?>
	</a>
	<?php endif; ?>

	<?php if ($stage = $action->job->previous()): ?>
	<a class="btn btn-link float-right" href="<?= site_url($stage->action->getRoute($action->job->id)) ?>" role="button" onclick="return confirm('Are you sure you want to regress this job?');">
		<i class="fas fa-arrow-circle-left"></i> <?= $stage->name ?>
	</a>
	<?php endif; ?>

	<h4><?= $action->job->name ?></h4>

	<hr>
