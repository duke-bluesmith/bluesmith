<?= $this->setVar('menu', $menu ?? '')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="container">

	<?= form_open('jobs/charges/' . $job->id) ?>
		<input class="btn btn-primary mb-3" type="submit" name="save" value="<?= lang('Pub.saveContinue') ?>">	
	<?= form_close() ?>

	<div class="row">
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
		<div class="col-sm-2"></div>
		<div class="col-sm-4">
			<h3>Suggestions</h3>
			<ul class="list-unstyled">

				<?php foreach ($items as $item): ?>
				<li><?= view('actions/charges/add', $item) ?></li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>

	<h2>Current Charges</h2>

	<?php if (empty($estimate->charges)): ?>
	<p><em>No charges have been set.</em></p>
	<?php else: ?>
	<?= view('actions/charges/table', ['mayDelete' => true, 'charges' => $estimate->charges]) ?>
	<?php endif; ?>

</div>

<?= $this->endSection() ?>
