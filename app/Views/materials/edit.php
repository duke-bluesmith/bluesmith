<?= $this->setVar('menu', 'materials')->extend(config('Layouts')->manage) ?>
<?= $this->section('main') ?>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Edit Material</h1>

<div class="row">
	<div class="col">
		<?= view('materials/form', ['material' => $material, 'methodOptions' => $methodOptions]) ?>
	</div>
	<div class="col-md"></div>
	<div class="col-xl"></div>
</div>

<?= $this->endSection() ?>
