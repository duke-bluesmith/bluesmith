<?= $this->setVar('menu', 'materials')->extend(config('Layouts')->manage) ?>
<?= $this->section('main') ?>

<script src="<?= base_url('/assets/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800"><?= $method->name ?> Materials</h1>

	<?php if (empty($method->materials)): ?>

<p>This method has no defined materials. Would you like to <a href="<?= site_url('manage/materials/new/' . $method->id) ?>">add one now</a>?</p>

<?php else: ?>

<p class="mb-4">Available printing materials for <?= $method->name ?></p>

	<?= view('materials/cards', ['materials' => $method->materials]) ?>

<?php endif; ?>

<?= $this->endSection() ?>
