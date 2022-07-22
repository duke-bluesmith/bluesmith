<?= $this->setVar('menu', 'methods')->extend(config('Layouts')->manage) ?>
<?= $this->section('main') ?>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Remove Material</h1>

<div class="row">
	<div class="col">
		<?= view('materials/confirm') ?>
	</div>
	<div class="col-md"></div>
	<div class="col-xl"></div>
</div>

<?= $this->endSection() ?>
