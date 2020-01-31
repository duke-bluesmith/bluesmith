<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">

	<?= form_open('jobs/options/' . $job->id) ?>

		<input class="btn btn-primary float-md-right" type="submit" name="submit" value="<?= lang('Pub.saveContinue') ?>">	
		
		<h2 class="my-4"><?= plural(lang('Pub.jobOption')) ?></h2>
		<p><?= lang('Tasks.optionsHelp') ?></p>
		
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
						<label class="custom-control-label" for="material-0"><?= lang('Tasks.chooseForMe') ?></label>
					</div>

					<button
						class="btn btn-secondary <?= $job->material_id ? 'active' : '' ?>"
						<?= $job->material_id ? 'data-toggle="button" aria-pressed="true"' : 'data-toggle="button" aria-pressed="false"' ?>
						autocomplete="off"
						onclick="$('#methods').toggleClass('invisible'); return false;"
					><?= lang('Tasks.chooseMyOwn') ?></button>
				</p>

				<div id="methods" class="card-deck <?= $job->material_id ? '' : 'invisible' ?>">

					<?php foreach ($methods as $method): ?>
					
					<div class="card mb-4" style="min-width: 14rem; max-width: 33rem;">
						<div class="card-body">
							<h5 class="card-title"><?= $method->name ?></h5>
							<h6 class="card-subtitle mb-2 text-muted"><?= $method->summary ?: '&nbsp;' ?></h6>
							<button class="btn btn-info" onclick="$('#methodDetails<?= $method->id ?>').modal(); return false;"><?= lang('Pub.details') ?></button>
						</div>
						
						<ul class="list-group list-group-flush">
							
						<?php foreach ($method->materials as $material): ?>

							<li
								class="list-group-item d-flex justify-content-between align-items-center"
								data-toggle="tooltip"
								data-placement="right"
								title="<?= htmlentities($material->description) ?>"
							>
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

								<span class="badge badge-info"><i class="fas fa-info-circle"></i></span>
							</li>

						<?php endforeach; ?>

						</ul>
						
						<div class="modal fade" id="methodDetails<?= $method->id ?>" tabindex="-1" role="dialog" aria-labelledby="methodDetails<?= $method->id ?>Title" aria-hidden="true">
							<div class="modal-dialog modal-dialog-scrollable" role="document">
							<div class="modal-content">
								<div class="modal-header">
								<h5 class="modal-title" id="methodDetails<?= $method->id ?>Title"><?= $method->name ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								</div>
								<div class="modal-body">
									<?= $method->description ?>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>

					</div>

					</div>
					
					<?php endforeach; ?>
					
				</div>

			</div>
		</div>

	<?= form_close() ?>
	
</div>

<?= $this->endSection() ?>
