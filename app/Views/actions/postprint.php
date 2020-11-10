<?= $this->setVar('menu', $menu ?? '')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="container">

	<p>Post print dialog here.</p>

	<?= form_open('jobs/postprint/' . $job->id) ?>

		<input class="btn btn-primary float-md-right" type="submit" name="save" value="<?= lang('Pub.saveContinue') ?>">	

	<?= form_close() ?>

</div>

<?= $this->endSection() ?>
