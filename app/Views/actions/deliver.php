<?= $this->extend('layouts/manage') ?>
<?= $this->section('main') ?>

	<?= form_open() ?>
		<input class="btn btn-success" type="submit" name="complete" value="<?= $buttonText ?>">
	<?= form_close() ?>

<?= $this->endSection() ?>
