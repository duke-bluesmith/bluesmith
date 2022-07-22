<?= $this->setVar('menu', 'branding')->extend(config('Layouts')->manage) ?>
<?= $this->section('main') ?>

<script src="<?= base_url('/assets/vendor/tinymce/tinymce.min.js') ?>" type="text/javascript"></script>

<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800">Branding</h1>
<p class="mb-4">Site-wide settings to configure project visuals and branding</p>

<!-- Content Row -->
<div class="row">
	<div class="col-xl-4 col-lg-6">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Organization</h6>
			</div>
			<div class="card-body">
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="orgName">Name</label>
						<input type="text" name="orgName" class="form-control" id="orgName" aria-describedby="orgNameHelp" placeholder="Organization" value="<?= $settings->orgName ?>">
						<small id="orgNameHelp" class="form-text text-muted"><?= $settings->getTemplate('orgName')->summary ?></small>
					</div>

					<img src="<?= $settings->orgLogo ?>" alt="Organization logo" style="float:right; max-height:100px; max-width:100%;" />
					<div class="form-group">
						<label for="orgLogo">Logo</label>
						<input type="file" name="orgLogo" class="form-control-file" id="orgLogo" aria-describedby="orgLogoHelp">
						<small id="orgLogoHelp" class="form-text text-muted"><?= $settings->getTemplate('orgLogo')->summary ?></small>
					</div>

					<div class="form-group">
						<label for="orgUrl">URL</label>
						<input type="url" name="orgUrl" class="form-control" id="orgUrl" aria-describedby="orgUrlHelp" placeholder="https://example.com" value="<?= $settings->orgUrl ?>">
						<small id="orgUrlHelp" class="form-text text-muted"><?= $settings->getTemplate('orgUrl')->summary ?></small>
					</div>

					<div class="form-group">
						<label for="orgPhone">Phone</label>
						<input type="phone" name="orgPhone" class="form-control" id="orgPhone" aria-describedby="orgPhoneHelp" placeholder="(951) 262-3062" value="<?= $settings->orgPhone ?>">
						<small id="orgPhoneHelp" class="form-text text-muted"><?= $settings->getTemplate('orgPhone')->summary ?></small>
					</div>

					<div class="form-group">
						<label for="orgAddress">Address</label>
						<textarea name="orgAddress" class="form-control" id="orgAddress" aria-describedby="orgAddressHelp"
							placeholder="4141 Postmark Dr  Anchorage, AK"><?= $settings->orgAddress ?></textarea>
						<small id="orgAddressHelp" class="form-text text-muted"><?= $settings->getTemplate('orgAddress')->summary ?></small>
					</div>

					<button type="submit" class="btn btn-primary float-right">Submit</button>
				</form>
			</div>
		</div>
    </div>

	<div class="col-xl-4 col-lg-6">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Project</h6>
			</div>
			<div class="card-body">
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="brandName">Name</label>
						<input type="text" name="brandName" class="form-control" id="brandName" aria-describedby="brandNameHelp" placeholder="Bluesmith" value="<?= $settings->brandName ?>">
						<small id="brandNameHelp" class="form-text text-muted"><?= $settings->getTemplate('brandName')->summary ?></small>
					</div>

					<img src="<?= $settings->brandLogo ?>" alt="Brand logo" style="float:right; max-height:100px; max-width:100%;" />
					<div class="form-group">
						<label for="brandLogo">Logo</label>
						<input type="file" name="brandLogo" class="form-control-file" id="brandLogo" aria-describedby="brandLogoHelp">
						<small id="brandLogoHelp" class="form-text text-muted"><?= $settings->getTemplate('brandLogo')->summary ?></small>
					</div>

					<div class="form-group">
						<label for="brandName">Default theme</label>
						<?= themes_select('custom-select', $settings->getTemplate('theme')->content) ?>
						<small id="themeHelp" class="form-text text-muted"><?= $settings->getTemplate('theme')->summary ?></small>
					</div>

					<button type="submit" class="btn btn-primary float-right">Submit</button>
				</form>
			</div>
		</div>
    </div>

	<div class="col-xl-4 col-lg-6">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Timezones</h6>
			</div>
			<div class="card-body">
				<form method="post">
					<div class="form-group">
						<label for="timezone">Default</label>
						<?= timezone_select('custom-select', $settings->getTemplate('timezone')->content) ?>
						<small id="timezoneHelp" class="form-text text-muted"><?= $settings->getTemplate('timezone')->summary ?></small>
					</div>

					<div class="form-group">
						<label for="serverTimezone">Server</label>
						<?= timezone_select('custom-select', $settings->getTemplate('serverTimezone')->content) ?>
						<small id="serverTimezoneHelp" class="form-text text-muted"><?= $settings->getTemplate('serverTimezone')->summary ?></small>
					</div>

					<div class="form-group">
						<label for="databaseTimezone">Database</label>
						<?= timezone_select('custom-select', $settings->getTemplate('databaseTimezone')->content) ?>
						<small id="databaseTimezoneHelp" class="form-text text-muted"><?= $settings->getTemplate('databaseTimezone')->summary ?></small>
					</div>

					<button type="submit" class="btn btn-primary float-right">Submit</button>
				</form>
			</div>
		</div>
    </div>
</div>

<?= $this->endSection() ?>
