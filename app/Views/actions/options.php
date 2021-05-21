<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<?= form_open('jobs/options/' . $job->id) ?>

		<input class="btn btn-primary float-md-right" type="submit" name="submit" value="<?= lang('Pub.saveContinue') ?>">	
		
		<h2 class="my-4"><?= plural(lang('Pub.jobOption')) ?></h2>
		<p><?= lang('Actions.optionsHelp') ?></p>
		
		<div class="row">
			
			<div class="col">
		
				<h3><?= plural(lang('Pub.printService')) ?></h3>
				
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

				<h3 class="mt-5"><?= lang('Pub.printMethodAndMaterials') ?></h3>
				
				<p>
					<div class="custom-control custom-radio mb-3">
						<input type="radio" id="material-0" name="material_id" class="custom-control-input" value="0" <?= $job->material_id ? '' : 'checked' ?>>
						<label class="custom-control-label" for="material-0"><?= lang('Actions.chooseForMe') ?></label>
					</div>

					<button
						class="btn btn-secondary <?= $job->material_id ? 'active' : '' ?>"
						<?= $job->material_id ? 'data-toggle="button" aria-pressed="true"' : 'data-toggle="button" aria-pressed="false"' ?>
						autocomplete="off"
						onclick="$('#methods').toggleClass('invisible'); return false;"
					><?= lang('Actions.chooseMyOwn') ?></button>
				</p>

				<div id="methods" class="<?= $job->material_id ? '' : 'invisible' ?>">

					<?php foreach ($methods as $method): ?>

					<h4 class="mt-5"><?= $method->name ?></h4>
					<p class="text-muted"><?= $method->summary  ?></p>
					<p><?= $method->description ?></p>

					<div class="card-deck">

						<?php foreach ($method->materials as $material): ?>
						<div class="card mb-4" style="min-width: 20rem; max-width: 33rem;">
							<div class="card-header">
								<h5 class="card-title">
									<div class="custom-control custom-radio">
										<input
											type="radio"
											id="material-<?= $material->id ?>"
											name="material_id"
											class="custom-control-input"
											value="<?= $material->id ?>"
											<?= $material->id == $job->material_id ? 'checked' : '' ?>
										>
										<label class="custom-control-label" for="material-<?= $material->id ?>"><?= $material->name ?></label>
									</div>
								</h5>
								<h6 class="card-subtitle mb-2 text-muted"><?= $material->summary ?: '&nbsp;' ?></h6>
							</div>
							<div class="card-body">
								<p><?= $material->description ?></p>
							</div>

							<?php if ($job->volume && $material->cost): ?>
							<div
								class="card-footer"
								data-toggle="tooltip"
								data-placement="right"
								title="<?= lang('Actions.optionsEstimate') ?>"
							>
								Material cost estimate: <?= price_to_currency($job->volume * $material->cost / 1000) ?>
								<span class="badge badge-info float-right"><i class="fas fa-info-circle"></i></span>
							</div>
							<?php endif; ?>

						</div>
						<?php endforeach; ?>

					</div>
					<?php endforeach; ?>

				</div>
			</div>
		</div>

	<?= form_close() ?>
	
<?= $this->endSection() ?>
