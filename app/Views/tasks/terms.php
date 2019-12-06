<?= $this->setVar('menu', $menu ?? '')->extend('layouts/public') ?>
<?= $this->section('main') ?>

<div class="container">

	<?= form_open('jobs/terms/' . $job->id) ?>

		<input class="btn btn-primary float-md-right" type="submit" name="accept" value="<?= lang('Pub.accept') ?>">	
		
		<div class="row">
			<div class="col">

				<?= $page->content ?? lang('Tasks.genericTerms') ?></p>
				
			</div>
		</div>
	
	<?= form_close() ?>

</div>
<?= $this->endSection() ?>
