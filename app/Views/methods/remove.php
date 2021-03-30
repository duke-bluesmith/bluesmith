<?= $this->setVar('menu', 'methods')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Remove Method</h1>

<div class="row">
	<div class="col">
		<?= view('methods/confirm') ?>
	</div>
	<div class="col-md"></div>
	<div class="col-xl"></div>
</div>

<?= $this->endSection() ?>
