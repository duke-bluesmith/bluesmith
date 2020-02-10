<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<a class="btn btn-primary float-md-right mb-3" href="<?= site_url(config('Workflows')->routeBase . '/' . $job->id) ?>">Continue Job</a>

	<h2><?= $job->name ?></h2>

	<div class="row">
		<div class="col-md-8">
			<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="progress-tab" data-toggle="tab" href="#progress" role="tab" aria-controls="progress" aria-selected="true">Progress</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Details</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Activity</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
				</li>
			</ul>

			<div class="tab-content" id="tabContent">
				 <div class="tab-pane fade show active" id="progress" role="tabpanel" aria-labelledby="progress-tab">
					<ul class="list-group">

					<?php foreach ($job->stages as $stage): ?>
			
						<li class="list-group-item">
							<?php if ($stage->id < $job->stage_id): ?>

							<i class="far fa-check-square mr-1"></i>
					
							<?php else: ?>

							<i class="far fa-square mr-1"></i>

							<?php endif; ?>

							<?= $stage->task->summary ?>
						</li>

					<?php endforeach; ?>

					</ul>
				</div>

				<div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">

					<p><?= $job->summary ?></p>

					<table class="table">

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
							<td><?= $option->name ?></td>
						</tr>

					<?php endforeach; ?>

					</table>

					<a href="#" class="btn btn-secondary">Change</a>


				</div>

				<div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
					...
				</div>

				<div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">

					<?php helper('files'); ?>
					<?= view('Tatter\Files\Views\\formats\\cards', ['files' => $job->files, 'access' => 'display']) ?>

				</div>
			</div>
		</div>

		<div class="col-md-4 mt-md-0 mt-4">

			<?php helper('chat'); ?>
			<?= chat('job-' . $job->id, 'Staff support') ?>

		</div>
	</div>


<?= $this->endSection() ?>
