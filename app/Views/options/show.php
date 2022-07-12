<?php $this->extend('layouts/manage'); ?>
<?php $this->section('main'); ?>

<!-- Page Heading -->
<h1 class="h3 text-gray-800"><?= $option->name ?></h1>

<!-- Card deck -->
<div class="card-deck">
	<?= view('options/display', ['option' => $option]) ?>
</div>

<?= $this->endSection() ?>
