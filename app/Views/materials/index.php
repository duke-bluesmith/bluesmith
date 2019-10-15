<?= $this->setVar('menu', 'materials')->extend('layouts/manage') ?>
<?= $this->section('main') ?>

<script src="<?= base_url('/assets/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>

<!-- Page Heading -->
<button type="button" class="btn btn-primary float-right" onclick="return desktopModal('materials/new');"><i class="fas fa-plus-circle"></i> Add material</button>
<h1 class="h3 mb-0 text-gray-800">Materials</h1>

<?php if (empty($materials)): ?>

<p>There are no defined materials. Would you like to <a href="<?= site_url('manage/materials/new') ?>" onclick="return desktopModal('materials/new');">add one now</a>?</p>

<?php else: ?>

<p class="mb-4">Available printing materials</p>

	<?= view('materials/cards', ['materials' => $materials]) ?>

<?php endif; ?>

<?= $this->endSection() ?>
