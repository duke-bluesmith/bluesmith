<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">	
	<div class="row">
		<?= form_open('jobs/options/' . $job->id) ?>

			<div class="col-lg-9">
		
				<h2><?= ucfirst(plural(lang('Pub.printOption'))) ?></h2>
				
				<?php foreach ($options as $option): ?>

				<div class="custom-control custom-switch mb-3">
					<input type="checkbox" name="options[]" class="custom-control-input" id="<?= $option->name ?>" value="<?= $option->name ?>">
					<label class="custom-control-label font-weight-bold" for="<?= $option->name ?>"><?= $option->summary ?></label>
					<br />
					<small class="text-muted"><?= $option->description ?></small>
				</div>

				<?php endforeach; ?>

				<h2><?= ucfirst(plural(lang('Pub.printMethod'))) ?></h2>
				<?php d($job, $methods); ?>
			</div>
			
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>
