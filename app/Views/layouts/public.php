<?php
$settings = service('settings');
$menu = $menu ?? '';
$current = ' <span class="sr-only">(current)</span>';
?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!--Mobile meta-data -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name="description" content="Bluesmith 3D Print Job Management" />
	<meta name="keywords" content="Bluesmith,3D print,job,manage" />
	<meta name="author" content="Duke University OIT" />
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

	<title>Bluesmith<?= empty($title) ? '' : " | {$title}" ?></title>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url() ?>assets/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?= base_url() ?>assets/favicon/safari-pinned-tab.svg" color="#012169">
	<link rel="shortcut icon" href="<?= base_url() ?>assets/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#2b5797">
	<meta name="msapplication-config" content="<?= base_url() ?>assets/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

	<?= service('assets')->tag('vendor/jquery/jquery.min.js') ?>

	<?= service('assets')->css() ?>

	<?= view('Tatter\Themes\Views\css') ?>

	<?= $this->renderSection('headerAssets') ?>

</head>
<body>
	<header id="banner" role="banner">
		<div class="container">
			<div id="banner-logo">
				<p>
					<a href="<?= $settings->orgUrl ?>"><img src="<?= base_url($settings->orgLogo) ?>" height="60" class="align-middle" alt="logo"></a>
					<a href="<?= site_url() ?>"><?= $settings->brandName ?></a>
				</p>
			</div>

			<div id="banner-tools">

				<?= themes_form('themed-select custom-select custom-select-sm') ?>

				<?php if (logged_in()): ?>

				<a href="<?= route_to('logout') ?>"><i class="fas fa-sign-out-alt"></i>Logout</a>

				<?php else: ?>

				<a href="<?= route_to('login') ?>"><i class="fas fa-unlock-alt"></i>Login</a>

				<?php endif; ?>

			</div>
    	</div>
	</header>

	<nav id="menu" class="navbar navbar-expand-lg <?= (theme()->dark) ? 'navbar-dark' : 'navbar-light' ?>" role="navigation">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				{{public-menu}}
			</div>
		</div>
	</nav>

	<?= service('alerts')->display() ?>

	<main id="main" role="main" class="container my-5">
		<?= $this->renderSection('main') ?>
	</main>

	<footer id="footer" class="footer fixed-bottom border-top">
		<div class="float-left">
			<a href="<?= $settings->orgUrl ?>"><img src="<?= base_url($settings->orgLogo) ?>" height="45" alt="logo"></a>
		</div>

		<div class="float-right copyright">
			&copy; <?= date('Y') ?>
			<?= $settings->orgName ?>
			<?= $settings->orgAddress ?>
			<?= $settings->orgPhone ?>
		</div>
	</footer>

	<script>
		var baseUrl = "<?= base_url() ?>";
		var siteUrl = "<?= site_url() ?>";
		var apiUrl  = "<?= site_url(config('Forms')->apiUrl) ?>";
	</script>

	<?= service('assets')->js() ?>

	<?= $this->renderSection('footerAssets') ?>

</body>
</html>
