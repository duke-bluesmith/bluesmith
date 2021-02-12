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
							<?php if (is_null($job->stage_id) || $job->stage_id > $stage->id): ?>

							<i class="far fa-check-square mr-1"></i>
					
							<?php else: ?>

							<i class="far fa-square mr-1"></i>

							<?php endif; ?>

							<?= $stage->action->summary ?>
						</li>

					<?php endforeach; ?>

					</ul>
				</div>

				<div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">

					<p><?= $job->summary ?></p>

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

					<a href="#" class="btn btn-secondary">Change</a>
				</div>

				<div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Action</th>
								<th scope="col">Status</th>
								<th scope="col">User</th>
								<th scope="col">Time</th>
							</tr>
						</thead>
						<tbody>

					<?php foreach ($logs as $log): ?>

							<tr>
								<td><?= $log->from->name ?? lang('Pub.newJob') ?></td>
								<td><?= (is_null($log->stage_to) || $log->stage_to > $log->stage_from) ? lang('Pub.complete') : lang('Pub.revert') ?>
								<td><?= $log->user ? $log->user->name : '' ?></td>
								<td><?= $log->created_at->humanize() ?></td>
							</tr>

					<?php endforeach; ?>
					
						</tbody>
					</table>
				</div>

				<div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">

<?php
// Display the Files card view partial
helper(['files', 'handlers']);
$data = [
	'files'   => $job->files,
	'access'  => 'display',
	'exports' => handlers('Exports')->findAll(),
];
echo view('Tatter\Files\Views\Formats\cards', $data)
?>


				</div>
			</div>
		</div>

		<div class="col-md-4 mt-md-0 mt-4">

			<?php helper('chat'); ?>
			<?= chat('job-' . $job->id, 'Staff support') ?>

		</div>
	</div>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>

	<!-- Modal -->
	<div class="modal fade" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="globalModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content" style="max-height:600px;">
				<div class="modal-header">
					<h5 class="modal-title" id="globalModalTitle"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body overflow-auto"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>
