<?php $this->extend('layouts/manage'); ?>
<?php $this->section('main'); ?>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Add Option</h1>

<div class="row">
	<div class="col">
		<?= view('options/form') ?>
	</div>
	<div class="col-md"></div>
	<div class="col-xl"></div>
</div>

<?php $this->endSection(); ?>
