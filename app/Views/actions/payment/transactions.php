<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<h3>Payment</h3>
	<h5><?= $invoice->job->name ?></h5>

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

	<?= form_open('jobs/payment/' . $invoice->job->id) ?>
		<h5><?= lang('Pub.transactions') ?></h5>
		<table class="table">
			<tr>
				<th scope="row">Your balance</th>
				<td><?= price_to_currency(user()->balance) ?></td>
			</tr>
			<tr>
				<th scope="row">Payment</th>
				<td><input type="text" name="amount" value="<?= old('amount', price_to_scaled(min(user()->balance, $invoice->due))) ?>" /></td>
			</tr>
		</table>

		<input type="hidden" name="_method" value="PATCH" />
		<input type="hidden" name="merchant" value="transactions" />
		<button class="btn btn-primary btn-sm mr-3" type="submit"><?= lang('Pub.submit') ?></button>
	<?= form_close() ?>

<?= $this->endSection() ?>
