<?= $this->setVar('menu', $menu ?? '')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

	<?= form_open('jobs/invoice/' . $job->id) ?>
		<input class="btn btn-primary float-md-right" type="submit" name="send" value="<?= lang('Pub.send') ?>">
	<?= form_close() ?>

	<h2 class="mb-4"><?= lang('Pub.invoice') ?></h2>

	<div class="row mb-4">
		<div class="col">
			<h4><?= lang('Pub.clients') ?></h4>

			<?php if (empty($job->users)): ?>
			<p><em><?= lang('Actions.noClients') ?></em></p>
			<p class="text-danger"><?= lang('Actions.noClients') ?></p>
		
			<?php else: ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Client</th>
						<th scope="col">Email</th>
						<th scope="col" class="text-center">Include?</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($job->users as $user): ?>

					<tr>
						<td><?= $user->firstname ?> <?= $user->lastname ?></td>
						<td><?= $user->email ?></td>
						<td class="text-center"><input type="checkbox" name="users[]" value="<?= $user->id ?>" checked></td>
					</tr>

					<?php endforeach; ?>

				</tbody>
			</table>
			<?php endif; ?>

		</div>
	</div>

	<div class="row">
		<div class="col">
			<span class="float-right h5">Total: <?= $invoice->getTotal(true) ?></span>
			<h4>Current Charges</h4>
			<?php if (empty($invoice->charges)): ?>
			<p class="text-danger">No charges have been set.</p>
			<?php else: ?>
			<?= view('actions/charges/table', ['mayDelete' => true, 'charges' => $invoice->charges]) ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col">
			<h4>Add a Charge</h4>

			<?= form_open('jobs/invoice/' . $job->id) ?>
				<input type="hidden" name="_method" value="PUT" />

				<div class="form-row mb-1">
					<div class="col-6">
						<label class="sr-only" for="name-add">Description</label>
						<input type="text" name="name" id="name-add" class="form-control" placeholder="Description">
					</div>
					<div class="col-2">
						<label class="sr-only" for="quantity-add">Quantity</label>
						<input type="text" name="quantity" id="quantity-add" class="form-control" placeholder="Qty">
					</div>
					<div class="col-3">
						<label class="sr-only" for="amount-add">Price</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">$</div>
							</div>
							<input type="text" name="amount" id="amount-add" class="form-control" placeholder="Price">
						</div>
					</div>
					<div class="col-1">
						<button class="btn btn-primary" type="submit" name="charge-add"><?= lang('Pub.add') ?></button>
					</div>
				</div>
			<?= form_close() ?>

		</div>
	</div>

	<div class="row mb-4">
		<div class="col">
			<h4>Additional Notes</h4>
			<textarea class="form-control mb-3" name="description" rows="8" placeholder="Additional notes..."><?= old('description') ?></textarea>
		</div>
	</div>

<?= $this->endSection() ?>
