
	</main>

	<footer class="footer">
		<div class="float-left mx-4">
			<?= themes_form('themed-select custom-select custom-select-sm') ?>
		</div>
		<div class="container">
			<div class="col text-muted text-center">&copy; <?=date('Y') ?> Bluesmith</div>
		</div>
	</footer>
	
	<script>
		var baseUrl = "<?=base_url() ?>";
		var siteUrl = "<?=site_url() ?>";
	</script>
	
	<?= service('assets')->display('js') ?>

</body>
</html>
