<?= $this->extend(config('Layouts')->default) ?>
<?= $this->section('main') ?>

<?= view('jobs/display') ?>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>

	<!-- Modal -->
	<div class="modal fade" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="globalModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content" style="max-height:600px;">
				<div class="modal-header">
					<h5 class="modal-title" id="globalModalTitle"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body overflow-auto"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>
