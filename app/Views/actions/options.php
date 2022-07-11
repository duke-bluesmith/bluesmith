<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<?= form_open('jobs/options/' . $job->id) ?>

		<div class="row">

			<div class="col">

				<h3 class="mt-5"><?= lang('Pub.printMethodAndMaterials') ?></h3>
				<p>For more information about the print methods and materials visit the <?= anchor('about/options', 'Print Options page') ?>.

				<table class="table">
					<thead>
						<tr>
							<th scope="col">Print Method</th>
							<th scope="col">Print Material</th>
							<th scope="col" class="text-right">Estimated Cost<sup>1</sup></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3">
								<div class="custom-control custom-radio">
									<input type="radio" id="material-0" name="material_id" class="custom-control-input" value="0" <?= $job->material_id ? '' : 'checked' ?>>
									<label class="custom-control-label" for="material-0"><?= lang('Actions.chooseForMe') ?></label>
								</div>
							</td>
						</tr>
						<?php foreach ($methods as $method): ?>
						<?php foreach ($method->materials as $material): ?>

						<tr>
							<td>
								<div class="custom-control custom-radio">
									<input
										type="radio"
										id="material-<?= $material->id ?>"
										name="material_id"
										class="custom-control-input"
										value="<?= $material->id ?>"
										<?= $material->id === $job->material_id ? 'checked' : '' ?>
									>
									<label class="custom-control-label" for="material-<?= $material->id ?>"><?= $method->name ?></label>
								</div>
							</td>
							<td><?= $material->name ?></td>
							<td class="text-right"><?= ($job->volume && $material->cost) ? price_to_currency($job->volume * $material->cost / 1000) : '' ?></td>
						</tr>

						<?php endforeach; ?>
						<?php endforeach; ?>
					</tbody>
				</table>

				<p class="text-muted"><sup>1</sup> <?= lang('Actions.optionsEstimate') ?></p>

				<h3>Additional <?= plural(lang('Pub.printService')) ?> Offered</h3>

				<?php foreach ($options as $option): ?>

				<div class="custom-control custom-switch mb-3">
					<input
						type="checkbox"
						name="option_ids[]"
						class="custom-control-input"
						id="<?= $option->name ?>"
						value="<?= $option->id ?>"
						<?= $job->hasOption($option->id) ? 'checked' : '' ?>
					>
					<label class="custom-control-label font-weight-bold" for="<?= $option->name ?>"><?= $option->summary ?></label>

					<br />

					<small class="text-muted"><?= $option->description ?></small>
				</div>

				<?php endforeach; ?>

				<input class="btn btn-success" type="submit" name="complete" value="<?= $buttonText ?>">
			</div>
		</div>

	<?= form_close() ?>

<?= $this->endSection() ?>
