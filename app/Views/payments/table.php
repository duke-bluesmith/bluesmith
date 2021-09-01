
	<table class="table">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Date</th>
				<th scope="col">Method</th>
				<th scope="col">Amount</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($payments as $payment): ?>
			<tr>
				<td>#<?= $payment->id ?></td>
				<td><?= $payment->created_at->format('n/j/Y') ?></td>
				<td><?= service('handlers', 'Merchants')->getAttributes($payment->class)['name'] ?></td>
				<td><?= price_to_currency($payment->amount) ?></td>
				<td class="<?= $payment->code ? 'text-danger' : '' ?>"><?= $payment->status ?></td>
			</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
