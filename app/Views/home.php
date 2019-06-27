<?= view('templates/header') ?>

<div class="container">
	<div class="row">
		<div class="col">
			<?= $content ?>
		</div>
		
		<div class="float-right">
			<a href="<?= site_url('jobs/new') ?>" class="btn btn-primary">Submit a job now</a>
		</div>
	</div>
</div>

<?= view('templates/footer') ?>
