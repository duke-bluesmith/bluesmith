<?= $this->extend('layouts/manage') ?>
<?= $this->section('main') ?>

	<?= form_open() ?>
	<?= $actionMenu ?>
	<?= form_close() ?>

	<p>Mark this job as "Delivered" once the printed parts have been received by the client.</p>

<?= $this->endSection() ?>
