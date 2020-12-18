<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">

	<h3>Payment</h3>
	<h5><?= $job->name ?></h5>

	<table class="table">
		<tr>
			<th scope="row">Total Amount</th>
			<td><?= $invoice->getTotal(true) ?></td>
		</tr>
		<tr>
			<th scope="row">Amount Paid</th>
			<td><?= $invoice->getPaid(true) ?></td>
		</tr>
		<tr>
			<th scope="row">Amount Due</th>
			<td><?= $invoice->getDue(true) ?></td>
		</tr>
	</table>

	<hr>

	<?php if (count($merchants)): ?>
	<p>Select your payment method to continue...</p>
	<ul>

		<?php foreach ($merchants as $merchant): ?>
		<li>

		<?= form_open('jobs/payment/' . $job->id) ?>
			<input type="hidden" name="_method" value="PUT" />
			<input type="hidden" name="merchant" value="<?= $merchant->uid ?>" />

			<button class="btn btn-primary btn-sm mr-3" type="submit"><?= $merchant->name ?></button>
			<?= $merchant->summary ?>
		<?= form_close() ?>

		</li>
		<?php endforeach; ?>

	</ul>

	<?php else: ?>
	<p class="text-danger">No eligible payment gateways. Please contact support.</p>
	<?php endif; ?>

</div>

<?= $this->endSection() ?>
