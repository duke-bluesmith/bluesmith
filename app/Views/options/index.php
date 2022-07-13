<?php $this->extend('layouts/manage'); ?>
<?php $this->section('main'); ?>

<!-- Page Heading -->
<a class="btn btn-primary float-right" href="<?= site_url('manage/options/new') ?>"><i class="fas fa-plus-circle"></i> Add option</a>
<h1 class="h3 mb-0 text-gray-800">Print Options</h1>
<p class="mb-4">Available print options</p>

<?php if (empty($options)): ?>

<p>There are no defined print options. Would you like to <a href="<?= site_url('manage/options/new') ?>">add one now</a>?</p>

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
		<div class="card-footer">
			<a class="btn btn-primary" href="<?= site_url("manage/options/edit/{$option->id}") ?>">Edit</a>
			<a class="btn btn-link text-danger float-right" href="<?= site_url("manage/options/remove/{$option->id}") ?>">Delete</a>
		</div>
	</div>

	<?php endforeach; ?>

</div>

<?php endif; ?>

<?= $this->endSection() ?>
