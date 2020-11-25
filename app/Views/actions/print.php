<?= $this->setVar('menu', $menu ?? '')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="container">

	<?= form_open() ?>

		<input class="btn btn-primary float-md-right" type="submit" name="complete" value="<?= lang('Pub.complete') ?>">	

	<?= form_close() ?>

	<h2><?= $action ?></h2>
	<h3><?= $job->name ?></h3>
	<div class="row">
		<div class="col-sm-6">
			<h5>Details</h5>
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
			<p><?= $job->summary ?></p>
		</div>

		<div class="col-sm-6">
			<h5>Charges</h5>

			<?php if (empty($estimate->charges)): ?>
			<p>No charges have been set.</p>
			<?php else: ?>
			<?= view('actions/charges/table', ['mayDelete' => false]) ?>
			<?php endif; ?>

			<span class="float-right h5">Total: <?= $estimate->getTotal(true) ?></span>
		</div>
	</div>

	<div class="row mt-5">
		<div class="col">
			<p class="small text-secondary float-right">Staff notes are not visible to clients</p>
			<h3>Staff Notes</h3>
			<div id="notes" style="max-height: 800px; overflow-x: hidden; overflow-y: scroll;">

				<?php foreach ($job->notes ?? [] as $note): ?>
				<?php if (empty($day) || $day !== $note->created_at->format('n/j/Y')): ?>
				<?php $day = $note->created_at->format('n/j/Y'); ?>
				<div class="row">
					<div class="col-5"><hr></div>
					<div class="col-2"><?= $day ?></div>
					<div class="col-5"><hr></div>
				</div>
				<?php endif; ?>

				<div class="row py-2 border-bottom">
					<div class="col-1">
						<span class="d-inline-block m-1 p-2 rounded-circle text-uppercase text-light bg-dark"
							data-toggle="tooltip" title="<?= $note->user->username ?>"><?= substr($note->user->username, 0, 2) ?></span>
					</div>
					<div class="col-11">
						<h6><?= $note->user->username ?> <span class="badge badge-secondary"><?= $note->created_at->format('g:i A') ?></span></h6>
						<div class="note-content">
							<?= $note->getContent(true) ?>
						</div>
					</div>
				</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">

			<?= form_open() ?>
				<input type="hidden" name="_method" value="PUT" />
				<textarea class="form-control" name="content" placeholder="Markdown content..."></textarea>
				<input class="btn btn-primary float-md-right" type="submit" name="send" value="<?= lang('Pub.send') ?>">
			<?= form_close() ?>

		</div>
	</div>
</div>

<?= $this->endSection() ?>
