<?= $this->setVar('menu', "pages.{$name}")->extend(config('Layouts')->manage) ?>

<?= $this->section('headerAssets') ?>
	<?= service('assets')->tag('vendor/jquery/jquery.min.js') ?>
	<?= service('assets')->tag('vendor/tinymce/tinymce.min.js') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Content Management</h1>
</div>

<!-- Content Row -->
<div class="row">
	<div class="col-md-8">
		<div class="card shadow mb-4 tinymce-wrapper">

			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><?= $name ?> Page</h6>
			</div>

			<div class="card-body">
				<form method="post">
					<textarea name="content" id="tinymce" style="visibility:hidden;"><?= $content ?></textarea>
					<input name="name" type="hidden" value="<?= $name ?>" />
				</form>
			</div>
		</div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>
<script>
	$(document).ready(function() {
		tinymce.init({
			selector: '#tinymce',
			height: 600,
			plugins: "code link save",
			menubar: "file edit insert format table tools",
			toolbar: "code link save"
		});
	});
</script>
<?= $this->endSection() ?>
