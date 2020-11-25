
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Description</th>
				<th scope="col">Quantity</th>
				<th scope="col">Price</th>
				<th scope="col">Subtotal</th>
				<?php if ($mayDelete): ?>
				<th scope="col"></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>

		<?php foreach ($estimate->charges as $i => $charge): ?>
			<tr>
				<td><?= $charge->name ?></td>
				<td><?= $charge->quantity ?></td>
				<td><?= price_to_scaled($charge->price, null, true) ?></td>
				<td><?= $charge->getAmount(true) ?></td>
				<?php if ($mayDelete): ?>
				<td>
					<?= view('actions/charges/delete', ['charge' => $charge]) ?>
				</td>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>

		</tbody>
	</table>
