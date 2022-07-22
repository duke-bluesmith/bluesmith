<?= $this->setVar('menu', 'materials')->extend(config('Layouts')->manage) ?>
<?= $this->section('main') ?>

<!-- Page Heading -->
<h1 class="h3 text-gray-800"><?= $material->name ?> Material</h1>

<!-- Card deck -->
<div class="card-deck">
	<?= view('materials/display', ['material' => $material]) ?>
</div>

<?= $this->endSection() ?>
