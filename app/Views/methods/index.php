<?php $this->setVar('header', 'Print Methods')->extend(config('Layouts')->manage); ?>
<?php $this->section('headerAssets'); ?>
<script src="<?= base_url('/assets/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>
<?php $this->endSection(); ?>
<?php $this->section('main'); ?>

<div class="row mb-3">
	<div class="col text-right">

        <?php if ($archive): ?>
		<a class="btn btn-info" href="<?= site_url('manage/methods') ?>"><i class="fas fa-trash-restore"></i> Exit Archive</a>
        <?php else: ?>
        <a class="btn btn-primary" href="<?= site_url('manage/methods/new') ?>"><i class="fas fa-plus-circle"></i> Add Method</a>
		<a class="btn btn-danger" href="<?= site_url('manage/methods?archive=1') ?>"><i class="fas fa-trash"></i> View Archive</a>
		<?php endif; ?>

	</div>
</div>

<?php if (empty($methods)): ?>
    <?php if ($archive): ?>
    <p>There are no archived print methods.</p>
    <?php else: ?>
    <p>There are no defined print methods. Would you like to <a href="<?= site_url('manage/methods/new') ?>">add one now</a>?</p>
    <?php endif; ?>
<?php else: ?>

<!-- Card deck -->
<div class="card-deck">

	<?php foreach ($methods as $method): ?>

	<div class="card shadow mb-4" style="min-width: 24rem; max-width: 36rem;">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><?= $method->name ?> <?= $method->summary && $method->name !== $method->summary ? "({$method->summary})" : '' ?></h6>
		</div>
		<div class="card-body">
			<p><a class="btn btn-light" href="<?= site_url('manage/materials/method/' . $method->id) ?>"><?= counted(count($method->materials), 'materials') ?></a></p>
			<p>
				<?= $method->description ?>
			</p>
		</div>

		<?php if ($method->deleted_at === null): ?>
		<div class="card-footer">
			<a class="btn btn-primary" href="<?= site_url("manage/methods/edit/{$method->id}") ?>">Edit</a>
			<a class="btn btn-link text-danger float-right" href="<?= site_url("manage/methods/remove/{$method->id}") ?>">Delete</a>
		</div>
		<?php endif; ?>

	</div>

	<?php endforeach; ?>

</div>

<?php endif; ?>

<?= $this->endSection() ?>
