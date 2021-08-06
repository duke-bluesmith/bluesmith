<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<?= form_open() ?>
	<?= $actionMenu ?>
	<?= form_close() ?>

	<div class="row">
		<div class="col">
			<?= $page->content ?? '<p>' . lang('Actions.genericTerms') . '</p>' ?>
		</div>
	</div>

<?= $this->endSection() ?>
