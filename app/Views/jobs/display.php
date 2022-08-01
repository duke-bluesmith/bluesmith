
<?php if ($job->deleted_at !== null): ?>
	<p><em>This job has been deleted.</em></p>
<?php else: ?>
	<a class="btn btn-danger float-md-right ml-3" href="<?= site_url('jobs/' . $job->id . '/delete') ?>" onclick="return confirm('Are you sure you want to remove this job?');">Move to Trash</a>
	<?php if ($job->stage_id !== null): ?>
	<a class="btn btn-primary float-md-right mb-3" href="<?= site_url(config('Workflows')->routeBase . '/' . $job->id) ?>">Continue Job</a>
	<?php endif; ?>
<?php endif; ?>

	<h4><?= $job->name ?></h4>
	<h5 class="mb-3">Job #<?= $job->id ?>, <?= $job->owner->name ?></h5>

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
				<li class="nav-item">
					<a class="nav-link" id="costs-tab" data-toggle="tab" href="#costs" role="tab" aria-controls="costs" aria-selected="false">Costs</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="clients-tab" data-toggle="tab" href="#clients" role="tab" aria-controls="clients" aria-selected="false">Clients</a>
				</li>
			</ul>

			<div class="tab-content" id="tabContent">
				 <div class="tab-pane fade show active" id="progress" role="tabpanel" aria-labelledby="progress-tab">
					<ul class="list-group">

					<?php foreach ($job->getWorkflow()->getStages() as $stage): ?>

						<li class="list-group-item">
							<?php if ($job->stage_id === null || $job->stage_id > $stage->id): ?>

							<i class="far fa-check-square mr-1"></i>
							<a href="<?= site_url($stage->getRoute() . $job->id) ?>" onclick="return confirm('Are you sure you want to regress this job?');"><?= $stage->getAction()::getAttributes()['summary'] ?></a>

							<?php else: ?>

							<i class="far fa-square mr-1"></i>
							<?= $stage->getAction()::getAttributes()['summary'] ?>

							<?php endif; ?>
						</li>

					<?php endforeach; ?>

					</ul>
				</div>

				<div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">

					<p><?= $job->summary ?></p>

					<table class="table">
						<tbody>
							<tr>
								<th scope="row">Created</th>
								<td><?= $job->created_at->format('F j, Y, g:ia') ?></td>
							</tr>

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

					<?php $logs = array_reverse($logs ?? []); ?>
					<?php foreach ($logs ?? [] as $log): ?>

							<tr>
								<td><?= $log->from->name ?? lang('Pub.newJob') ?></td>
								<td><?= (null === $log->stage_to || $log->stage_to > $log->stage_from) ? lang('Pub.complete') : lang('Pub.revert') ?>
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
    'exports' => \Tatter\Exports\Factories\ExporterFactory::findAll(),
];
echo view('Tatter\Files\Views\Formats\cards', $data);
?>

				</div>

				<div class="tab-pane fade" id="costs" role="tabpanel" aria-labelledby="costs-tab">

<?php
// Display Charges and Payments
helper(['currency', 'form']);
$estimate = $job->getEstimate();
$invoice  = $job->getInvoice();
?>
					<h4>Estimate</h4>

					<?php if ($estimate === null || empty($estimate->charges)): ?>
					<p><em>No estimate charges have been set.</em></p>
					<?php else: ?>
					<?= view('charges/table', ['mayDelete' => false, 'charges' => $estimate->charges]) ?>
					<?php endif; ?>

					<h4>Invoice</h4>

					<?php if ($invoice === null || empty($invoice->charges)): ?>
					<p><em>No invoice charges have been set.</em></p>
					<?php else: ?>
					<?= view('charges/table', ['mayDelete' => false, 'charges' => $invoice->charges]) ?>
					<?php endif; ?>

					<h4>Payments</h4>

					<?php if ($invoice === null || ! $invoice->hasPayments()): ?>
					<p><em>No payments have been made.</em></p>
					<?php else: ?>
					<?= view('payments/table', ['payments' => $invoice->payments]) ?>
					<?php endif; ?>

				</div>

				<div class="tab-pane fade" id="clients" role="tabpanel" aria-labelledby="clients-tab">
					<h4 class="mt-5"><?= lang('Actions.currentClients') ?></h4>

					<?php if (empty($job->users)): ?>
					<p><em><?= lang('Actions.noClients') ?></em></p>
					<?php else: ?>
					<?= view('clients/table', ['mayDelete' => false, 'users' => $job->users]) ?>
					<?php endif; ?>

                    <h4 class="mt-5"><?= lang('Actions.pendingClients') ?></h4>

                    <?php if (empty($job->invites)): ?>

                    <p><em><?= lang('Actions.noInvites') ?></em></p>

                    <?php else: ?>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Email</th>
                                <th scope="col">Issued</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($job->invites as $invite): ?>

                            <tr>
                                <td><?= $invite->email ?></td>
                                <td><?= $invite->created_at->humanize() ?></td>
                            </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php endif; ?>

					<?php if ($job->deleted_at === null): ?>

					<h4 class="mt-5">Add User</h4>

                    <?= form_open('clients/add/' . $job->id) ?>

                        <div class="form-group">
                            <label for="clientEmail">Email address</label>
                            <input type="email" name="email" class="form-control" id="clientEmail" aria-describedby="emailHelp" placeholder="<?= lang('Pub.email') ?>...">
                            <small id="emailHelp" class="form-text text-muted"><?= lang('Actions.clientEmailHelp') ?></small>
                        </div>
                        <input class="btn btn-secondary" type="submit" name="submit" value="<?= lang('Pub.add') ?>">

                    <?= form_close() ?>

                    <?php endif; ?>
				</div>
			</div>
		</div>

		<div class="col-md-4 mt-md-0 mt-4">

			<?php helper('chat'); ?>
			<?= chat('job-' . $job->id, 'Staff support') ?>

		</div>
	</div>
