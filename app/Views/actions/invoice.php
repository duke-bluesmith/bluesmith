<?= $this->setVar('menu', $menu ?? '')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="container">

	<?= form_open('jobs/invoice/' . $job->id) ?>

		<input class="btn btn-primary float-md-right" type="submit" name="send" value="<?= lang('Pub.send') ?>">

		<h3><?= lang('Pub.clients') ?></h3>

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
		<div class="col-sm-6">
			<h2>Add a Charge</h2>

			<?= form_open('jobs/charges/' . $job->id) ?>
				<input type="hidden" name="_method" value="PUT" />

				<div class="form-row mb-1">
					<div class="col-7">
						<label class="sr-only" for="name-add">Description</label>
						<input type="text" name="name" id="name-add" class="form-control" placeholder="Description">
					</div>
					<div class="col-2">
						<label class="sr-only" for="quantity-add">Quantity</label>
						<input type="text" name="quantity" id="quantity-add" class="form-control" placeholder="Qty">
					</div>
					<div class="col-3">
						<label class="sr-only" for="price-add">Price</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">$</div>
							</div>
							<input type="text" name="price" id="price-add" class="form-control" placeholder="Price">
						</div>
					</div>
				</div>

				<button class="btn btn-primary" type="submit" name="charge-add"><?= lang('Pub.add') ?></button>
			<?= form_close() ?>

		</div>

		<h2>Current Charges</h2>
		<?php if (empty($invoice->charges)): ?>
		<p class="text-danger">No charges have been set.</p>
		<?php else: ?>
		<?= view('actions/charges/table', ['mayDelete' => false, 'charges' => $invoice->charges]) ?>
		<?php endif; ?>


		<h3>Additional Notes</h3>
		<textarea class="form-control mb-3" name="description" rows="8" placeholder="Additional notes..."><?= old('description') ?></textarea>
	</div>
</div>

<?= $this->endSection() ?>
