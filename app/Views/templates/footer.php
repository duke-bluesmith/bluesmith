<?php
$settings = service('settings');
?>

	</main>

	<footer id="footer" class="footer float-left">
		<div class="float-left">
			<a href="<?= $settings->orgUrl ?>"><img src="<?= $settings->orgLogo ?>" height="45" alt="logo"></a>
		</div>
			
		<div class="float-right copyright">
			&copy; <?=date('Y') ?>
			<?= $settings->orgName ?>
			<?= $settings->orgAddress ?>
			<?= $settings->orgPhone ?>
		</div>
	</footer>
	
	<script>
		var baseUrl = "<?=base_url() ?>";
		var siteUrl = "<?=site_url() ?>";
	</script>
	
	<?= service('assets')->display('js') ?>

</body>
</html>
