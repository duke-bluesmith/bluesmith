<?php $this->setVar('header', 'Print Options')->extend('layouts/manage'); ?>
<?php $this->section('main'); ?>

<div class="row mb-3">
	<div class="col text-right">

        <?php if ($archive): ?>
		<a class="btn btn-info" href="<?= site_url('manage/options') ?>"><i class="fas fa-trash-restore"></i> Exit Archive</a>
        <?php else: ?>
        <a class="btn btn-primary" href="<?= site_url('manage/options/new') ?>"><i class="fas fa-plus-circle"></i> Add Option</a>
		<a class="btn btn-danger" href="<?= site_url('manage/options?archive=1') ?>"><i class="fas fa-trash"></i> View Archive</a>
		<?php endif; ?>

	</div>
</div>

<?php if (empty($options)): ?>
    <?php if ($archive): ?>
    <p>There are no archived print options.</p>
    <?php else: ?>
    <p>There are no defined print options. Would you like to <a href="<?= site_url('manage/options/new') ?>">add one now</a>?</p>
    <?php endif; ?>
<?php else: ?>

<!-- Card deck -->
<div class="card-deck">

	<?php foreach ($options as $option): ?>

	<div class="card shadow mb-4" style="min-width: 24rem; max-width: 36rem;">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><?= $option->summary ?></h6>
		</div>
		<div class="card-body">
			<p>
				<?= $option->description ?>
			</p>
		</div>

		<?php if ($option->deleted_at === null): ?>
		<div class="card-footer">
			<a class="btn btn-primary" href="<?= site_url("manage/options/edit/{$option->id}") ?>">Edit</a>
			<a class="btn btn-link text-danger float-right" href="<?= site_url("manage/options/remove/{$option->id}") ?>">Delete</a>
		</div>
		<?php endif; ?>

	</div>

	<?php endforeach; ?>

</div>

<?php endif; ?>

<?= $this->endSection() ?>
