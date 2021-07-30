<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!--Mobile meta-data -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<meta name="description" content="Admin Dashboard" />
	<meta name="keywords" content="admin,dashboard,management" />
	<meta name="author" content="AdminLTE" />
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

	<title><?= service('settings')->brandName ?> | <?= $header ?? 'Admin' ?></title>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('assets/favicon/apple-touch-icon.png') ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon/favicon-16x16.png') ?>">
	<link rel="manifest" href="<?= base_url('assets/favicon/site.webmanifest') ?>">
	<link rel="mask-icon" href="<?= base_url('assets/favicon/safari-pinned-tab.svg') ?>" color="#307093">
	<link rel="shortcut icon" href="<?= base_url('assets/favicon/favicon.ico') ?>">
	<meta name="msapplication-TileColor" content="#307093">
	<meta name="msapplication-config" content="<?= base_url('assets/favicon/browserconfig.xml') ?>">
	<meta name="theme-color" content="#307093">

	<?= service('assets')->tag('vendor/tinymce/tinymce.min.js') ?>
	
	<?= service('assets')->tag('vendor/jquery/jquery.min.js') ?>

	<?= service('assets')->css() ?>
	
	<?= service('alerts')->css() ?>

	<?= service('assets')->tag('vendor/adminlte/css/adminlte.min.css') ?>
	
	<?= $this->renderSection('headerAssets') ?>

</head>
<body class="hold-transition sidebar-mini accent-blue layout-footer-fixed">
<div class="wrapper">

	<?= service('alerts')->display() ?>

	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-blue navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?= base_url() ?>" class="nav-link">Home</a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?= site_url('manage') ?>" class="nav-link">Dashboard</a>
			</li>
		</ul>

		<!-- SEARCH FORM
		<form class="form-inline ml-3 invisible">
			<div class="input-group input-group-sm">
				<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
					<button class="btn btn-navbar" type="submit">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</div>
		</form>
		-->

		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
			</li>
		</ul>
	</nav>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<!-- Brand Logo -->
		<a href="<?= site_url('manage') ?>" class="brand-link">
			<img src="<?= base_url(service('settings')->brandLogo) ?>" alt="Logo" class="brand-image img-circle elevation-3 bg-white" style="opacity: .8">
			<span class="brand-text font-weight-light"><?= service('settings')->brandName ?></span>
		</a>

		<!-- Sidebar -->
		<div class="sidebar sidebar-dark-blue">

			<?php if ($user = user()): ?>
			<!-- Sidebar user panel (optional) -->
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<i class="fas fa-user"></i>
				</div>
				<div class="info">
					<a href="<?= site_url('manage/users/show/' . $user->id) ?>" class="d-block"><?= $user->username ?></a>
				</div>
			</div>
			<?php endif; ?>

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				{{manage-menu}}
			</nav>
			<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark"><?= $header ?? '' ?></h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						{{breadcrumbs}}
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content" style="min-height: 600px;">
			<div class="container-fluid text-dark">

			<?= $this->renderSection('main') ?>

			<?php if (isset($job) && $job instanceof \Tatter\Workflows\Entities\Job): ?>

			<!-- Job-specific staff notes -->
			<div class="staff-notes">
				<div class="row mt-5">
					<div class="col">
						<p class="small text-secondary float-right">Staff notes are not visible to clients</p>
						<h3>Staff Notes</h3>
						<div id="notes" style="max-height: 800px; overflow-x: hidden; overflow-y: scroll;">

							<?php foreach ($job->notes ?? [] as $note): ?>
							<?php if (empty($day) || $day !== $note->created_at->format('n/j/Y')): ?>
							<?php $day = $note->created_at->format('n/j/Y'); ?>
							<div class="row">
								<div class="col-5"><hr></div>
								<div class="col-2"><?= $day ?></div>
								<div class="col-5"><hr></div>
							</div>
							<?php endif; ?>

							<div class="row py-2 border-bottom">
								<div class="col-1">
									<span class="d-inline-block m-1 p-2 rounded-circle text-uppercase text-light bg-dark"
										data-toggle="tooltip" title="<?= $note->user->username ?>"><?= substr($note->user->username, 0, 2) ?></span>
								</div>
								<div class="col-11">
									<h6>
										<span class="badge badge-secondary mr-3"><?= $note->created_at->format('g:i A') ?></span>
										<?= $note->user->getName() ?>
									</h6>
									<div class="note-content">
										<?= $note->getContent(true) ?>
									</div>
								</div>
							</div>
							<?php endforeach; ?>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">

						<form action="<?= site_url('manage/notes/add') ?>" method="post">
							<input type="hidden" name="job_id" value="<?= $job->id ?>" />
							<textarea class="form-control" name="content" placeholder="Markdown content..."></textarea>
							<input class="btn btn-primary float-md-right" type="submit" name="send" value="<?= lang('Pub.send') ?>">
						</form>
					</div>
				</div>
			</div><!-- /.staff-notes -->

			<?php endif; ?>

			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
		<div class="p-3">
			<h5>Title</h5>
			<p>Sidebar content</p>
		</div>
	</aside>
	<!-- /.control-sidebar -->

	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- To the right -->
		<div class="float-right d-none d-sm-inline mr-4">
			<?= service('settings')->brandName ?>
		</div>
		<!-- Default to the left -->
		<strong>Copyright &copy; <?= date('Y') ?> <?= service('settings')->orgName ?></strong>
	</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script>
	var baseUrl = "<?= base_url() ?>";
	var siteUrl = "<?= site_url() ?>";
	var apiUrl  = "<?= site_url(config('Forms')->apiUrl) ?>";
</script>

<?= service('assets')->js() ?>

<?= service('assets')->tag('vendor/adminlte/js/adminlte.min.js') ?>

<?= $this->renderSection('footerAssets') ?>

</body>
</html>
