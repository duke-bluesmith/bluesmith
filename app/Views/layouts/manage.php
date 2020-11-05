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
	
	<?= $this->renderSection('headerAssets') ?>

</head>
<body class="hold-transition sidebar-mini accent-blue">
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
			<img src="<?= service('settings')->orgLogo ?>" alt="Logo" class="brand-image img-circle elevation-3 bg-white" style="opacity: .8">
			<span class="brand-text font-weight-light"><?= service('settings')->brandName ?></span>
		</a>

		<!-- Sidebar -->
		<div class="sidebar sidebar-dark-blue">
			<!-- Sidebar user panel (optional) -->
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<i class="fas fa-user"></i>
				</div>
				<div class="info">
					<a href="<?= site_url('manage/users/' . user()->id) ?>" class="d-block"><?= user()->username ?></a>
				</div>
			</div>

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item has-treeview menu-open">
						<a href="#" class="nav-link has-treeview <?= url_is('manage/jobs*') ? 'active' : '' ?>">
							<i class="nav-icon fas fa-th-list"></i>
							<p>
								Jobs
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= site_url('manage/jobs') ?>" class="nav-link <?= url_is('manage/jobs') ? 'active' : '' ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>All Jobs</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('mnage/jobs/staff') ?>" class="nav-link <?= url_is('manage/jobs/staff') ? 'active' : '' ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Action Items</p>
									<span class="right badge badge-warning">12</span>
								</a>
							</li>
						</ul>
					</li>

					<li class="nav-item has-treeview  <?= url_is('workflows*') || url_is('actions*') ? 'menu-open' : '' ?>">
						<a href="#" class="nav-link has-treeview <?= url_is('workflows*') || url_is('actions*') ? 'active' : '' ?>">
							<i class="nav-icon fas fa-project-diagram"></i>
							<p>
								Workflows
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= site_url('workflows') ?>" class="nav-link <?= url_is('workflows') ? 'active' : '' ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Index</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('actions') ?>" class="nav-link <?= url_is('actions') ? 'active' : '' ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Actions</p>
								</a>
							</li>
						</ul>
					</li>

					<li class="nav-header">CONTENT MANAGEMENT</li>

					<li class="nav-item has-treeview <?= url_is('emails/templates*') ? 'menu-open' : '' ?>">
						<a href="#" class="nav-link has-treeview <?= url_is('emails/templates*') ? 'active' : '' ?>">
							<i class="nav-icon fas fa-inbox"></i>
							<p>
								Email
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">

							<li class="nav-item">
								<a href="<?= site_url('emails/templates') ?>" class="nav-link <?= url_is('emails/templates') ? 'active' : '' ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>List Templates</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('emails/templates/new') ?>" class="nav-link <?= url_is('emails/templates/new*') ? 'active' : '' ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Add Template</p>
								</a>
							</li>

						</ul>
					</li>

					<li class="nav-item has-treeview <?= url_is('manage/content/page*') ? 'menu-open' : '' ?>">
						<a href="#" class="nav-link has-treeview <?= url_is('manage/content/page*') ? 'active' : '' ?>">
							<i class="nav-icon fas fa-file-alt"></i>
							<p>
								Pages
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">

							<?php foreach (model('App\Models\PageModel')->findAll() as $page): ?>
							<li class="nav-item">
								<a href="<?= site_url('manage/content/page/' . $page->name) ?>" class="nav-link <?= url_is('manage/content/page/' . $page->name) ? 'active' : '' ?>">
									<i class="far fa-circle nav-icon"></i>
									<?= ucfirst($page->name) ?>
								</a>
							</li>
							<?php endforeach; ?>
	
						</ul>
					</li>
					<li class="nav-item">
						<a href="<?= site_url('manage/methods') ?>" class="nav-link <?= url_is('manage/methods*') ? 'active' : '' ?>">
							<i class="nav-icon fas fa-cubes"></i>
							<p>Methods</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= site_url('manage/materials') ?>" class="nav-link <?= url_is('manage/materials*') ? 'active' : '' ?>">
							<i class="nav-icon fas fa-tools"></i>
							<p>Materials</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= site_url('manage/content/branding') ?>" class="nav-link <?= url_is('manage/content/branding*') ? 'active' : '' ?>">
							<i class="nav-icon fas fa-copyright"></i>
							<p>Branding</p>
						</a>
					</li>
				</ul>
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
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Starter Page</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid text-dark">

			<?= $this->renderSection('main') ?>

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
			Get Fit. Raise Money.
		</div>
		<!-- Default to the left -->
		<strong>Copyright &copy; <?=date('Y') ?> <?= service('settings')->orgName ?></strong>
	</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script>
	var baseUrl = "<?= base_url() ?>";
	var siteUrl = "<?= site_url('manage') ?>";
	var apiUrl  = "<?= site_url(config('Forms')->apiUrl) ?>";
</script>

<?= service('assets')->js() ?>

<?= $this->renderSection('footerAssets') ?>

</body>
</html>
