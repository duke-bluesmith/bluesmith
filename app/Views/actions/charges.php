<?= $this->setVar('menu', $menu ?? '')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<h2>Add a Charge</h2>

			<?= form_open('jobs/charges/' . $job->id) ?>
				<input type="hidden" name="_method" value="PUT" />

				<div class="form-row">
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

				<input class="btn btn-primary" type="submit" name="charge-add" value="<?= lang('Pub.add') ?>">	
			<?= form_close() ?>

		</div>
		<div class="col-sm-2"></div>
		<div class="col-sm-4">
			<h3>Job Details</h3>
			<ul>
				<li><?= $job->material->method->name ?></li>
				<li><?= $job->material->name ?></li>

				<?php foreach ($job->options as $option): ?>
				<li><?= $option->summary ?></li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>

	<input class="btn btn-primary float-md-right" type="button" value="<?= lang('Pub.saveContinue') ?>">
	<h2>Job Charges</h2>

	<?php if (empty($job->charges)): ?>
	<p><em>No charges have been set.</em></p>
	<?php else: ?>
	
	<?= form_open('jobs/charges/' . $job->id) ?>

		<?php foreach ($job->charges ?? [] as $i => $charge): ?>
		<div class="form-row">
			<div class="col-7">
				<label class="sr-only" for="name-<?= $i ?>">Description</label>
				<input type="text" name="name[]" id="name-<?= $i ?>" class="form-control" placeholder="Description" value="<?= $charge->name ?>">
			</div>
			<div class="col-2">
				<label class="sr-only" for="quantity-<?= $i ?>">Quantity</label>
				<input type="text" name="quantity[]" id="quantity-<?= $i ?>" class="form-control" placeholder="Qty" value="<?= $charge->quantity ?>">
			</div>
			<div class="col-3">
				<label class="sr-only" for="price-<?= $i ?>">Price</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">$</div>
					</div>
					<input type="text" name="price[]" id="price-<?= $i ?>" class="form-control" placeholder="Price" value="<?= $charge->scaled ?>">
				</div>
			</div>
		</div>
		<?php endforeach; ?>

	<?= form_close() ?>

	<?php endif; ?>

</div>

<?= $this->endSection() ?>
