
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Client</th>
						<th scope="col">Email</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($users as $user): ?>

					<tr>
						<td><?= $user->firstname ?> <?= $user->lastname ?></td>
						<td><?= $user->email ?></td>
						<td>
							<?php if ($mayDelete && count($users)>1): ?>
							
							<?= form_open('jobs/clients/' . $job->id, '', ['_method' => 'DELETE']) ?>

								<input type="hidden" name="user_id" value="<?= $user->id ?>">
								<input class="btn btn-link btn-small" type="submit" name="remove" value="<?= lang('Pub.remove') ?>">	

							<?= form_close() ?>
							
							<?php endif; ?>
						</td>
					</tr>

					<?php endforeach; ?>

				</tbody>
			</table>
