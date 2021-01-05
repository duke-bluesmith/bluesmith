<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<?php if ($invoice->due === 0): ?>
	<?= form_open('jobs/payment/' . $job->id) ?>

	<input class="btn btn-primary float-md-right" type="submit" name="save" value="<?= lang('Pub.saveContinue') ?>">	

	<?= form_close() ?>
	<?php endif; ?>

	<h3 class="mb-3"><?= $job->name ?></h3>
	<dl class="row">
		<dt class="col-3 col-lg-3">Total Amount</dt>
		<dd class="col-3 col-lg-9"><?= $invoice->getTotal(true) ?></dd>

		<dt class="col-3 col-lg-3">Amount Paid</dt>
		<dd class="col-3 col-lg-9"><?= $invoice->getPaid(true) ?></dd>

		<dt class="col-3 col-lg-3">Amount Due</dt>
		<dd class="col-3 col-lg-9"><?= $invoice->getDue(true) ?></dd>
	</dl>

	<h5>Payments</h5>

	<?php if ($invoice->hasPayments()): ?>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Date</th>
				<th scope="col">Method</th>
				<th scope="col">Amount</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($invoice->payments as $payment): ?>
			<tr>
				<td><?= $payment->created_at->format('n/j/Y') ?></td>
				<td><?= price_to_currency($payment->amount) ?></td>
				<td><?= service('handlers', 'Merchants')->getAttributes($payment->class)['name'] ?></td>
				<td class="<?= $payment->code ? 'text-danger' : '' ?>"><?= $payment->status ?></td>
			</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
	<?php else: ?>
	<p class="muted">No payments have been made.</p>
	<?php endif; ?>

	<hr>

	<?php if ($invoice->getDue() === 0): ?>

	<p class="text-success">Payment is complete!</p>
	<?= form_open('jobs/payment/' . $job->id) ?>

	<input class="btn btn-primary float-md-right" type="submit" name="save" value="<?= lang('Pub.saveContinue') ?>">	

	<?= form_close() ?>

	<?php elseif (count($merchants)): ?>

	<h5 class="my-3"><?= lang('Payment.add') ?></h5>

	<?= form_open('jobs/payment/' . $job->id) ?>

		<?php foreach ($merchants as $i => $merchant): ?>
		<div class="custom-control custom-radio">
			<input type="radio" id="merchant-<?= $i ?>" name="merchant" class="custom-control-input" value="<?= $merchant->uid ?>">
			<label class="custom-control-label" for="merchant-<?= $i ?>">
				<?= $merchant->name ?>
				<i class="fas fa-info-circle" data-toggle="tooltip" title="<?= $merchant->summary ?>"></i>
			</label>

			<?php if (! is_null($balance = $merchant->balance(user()))): ?>
			<small class="form-text text-muted"><?= price_to_currency(user()->balance) ?> balance</small>
			<?php endif; ?>

		</div>
		<?php endforeach; ?>

		<div class="form-group my-3">
			<label for="amount">Payment</label>
			<input type="number" name="amount" class="form-control" id="amount" aria-describedby="amountHelp" placeholder="Amount" value="<?= old('amount', price_to_scaled($invoice->due)) ?>" step="any">
			<small id="amountHelp" class="form-text text-muted"><?= lang('Payment.partial') ?></small>
		</div>

		<input type="hidden" name="_method" value="PUT" />
		<button class="btn btn-primary btn-sm mr-3" type="submit"><?= lang('Pub.submit') ?></button>
	<?= form_close() ?>

	<?php else: ?>
	<p class="text-danger">No eligible payment gateways. Please contact support.</p>
	<?php endif; ?>

<?= $this->endSection() ?>
