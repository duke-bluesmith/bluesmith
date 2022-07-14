<?php $this->setVar('header', 'Materials')->extend('layouts/manage'); ?>
<?php $this->section('headerAssets'); ?>
<script src="<?= base_url('/assets/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>
<?php $this->endSection(); ?>
<?php $this->section('main'); ?>

<div class="row mb-3">
	<div class="col text-right">

        <?php if ($archive): ?>
		<a class="btn btn-info" href="<?= site_url('manage/materials') ?>"><i class="fas fa-trash-restore"></i> Exit Archive</a>
        <?php else: ?>
        <a class="btn btn-primary" href="<?= site_url('manage/materials/new') ?>"><i class="fas fa-plus-circle"></i> Add Material</a>
		<a class="btn btn-danger" href="<?= site_url('manage/materials?archive=1') ?>"><i class="fas fa-trash"></i> View Archive</a>
		<?php endif; ?>

	</div>
</div>

<?php if (empty($materials)): ?>
    <?php if ($archive): ?>
    <p>There are no archived materials.</p>
    <?php else: ?>
    <p>There are no defined materials. Would you like to <a href="<?= site_url('manage/materials/new') ?>">add one now</a>?</p>
    <?php endif; ?>
<?php else: ?>

<?= view('materials/cards', ['materials' => $materials]) ?>

<?php endif; ?>

<?= $this->endSection() ?>
