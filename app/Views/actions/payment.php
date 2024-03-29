<?= $this->extend(config('Layouts')->default) ?>
<?= $this->section('main') ?>

	<h3 class="mb-3"><?= $job->name ?></h3>
	<dl class="row">
		<dt class="col-3 col-lg-3">Total Amount</dt>
		<dd class="col-3 col-lg-9"><?= $invoice->getTotal(true) ?></dd>

		<dt class="col-3 col-lg-3">Amount Paid</dt>
		<dd class="col-3 col-lg-9"><?= $invoice->getPaid(true) ?></dd>

		<dt class="col-3 col-lg-3">Amount Due</dt>
		<dd class="col-3 col-lg-9"><?= $invoice->getDue(true) ?></dd>
	</dl>

	<?php if ($invoice->due === 0): ?>
	<p class="text-success">Payment is complete!</p>
	<?php elseif (count($merchants)): ?>

	<h5 class="my-3"><?= lang('Payment.add') ?></h5>

	<?= form_open('jobs/payment/' . $job->id) ?>

		<?php foreach ($merchants as $i => $merchant): ?>
		<div class="custom-control custom-radio">
			<input type="radio" id="merchant-<?= $i ?>" name="merchant" class="custom-control-input" value="<?= $merchant::HANDLER_ID ?>">
			<label class="custom-control-label" for="merchant-<?= $i ?>">
				<?= $merchant->getName() ?>
				<i class="fas fa-info-circle" data-toggle="tooltip" title="<?= $merchant->getSummary() ?>"></i>
			</label>

			<?php if (null !== ($balance = $merchant->balance(user()))): ?>
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

	<hr>

	<h5>Payments</h5>

	<?php if ($invoice->hasPayments()): ?>
	<?= view('payments/table', ['payments' => $invoice->payments]) ?>
	<?php else: ?>
	<p class="muted">No payments have been made.</p>
	<?php endif; ?>

	<?php if ($invoice->due === 0): ?>

	<?= form_open() ?>
		<input class="btn btn-success" type="submit" name="complete" value="<?= $buttonText ?>">
	<?= form_close() ?>

	<?php endif; ?>


<?= $this->endSection() ?>
