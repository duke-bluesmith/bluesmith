<?= $this->setVar('menu', $menu ?? '')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<div class="container">

	<p>Billing info goes here.</p>

	<?= form_open('jobs/charges/' . $job->id) ?>

		<input class="btn btn-primary float-md-right" type="submit" name="save" value="<?= lang('Pub.saveContinue') ?>">	

	<?= form_close() ?>

</div>

<?= $this->endSection() ?>
