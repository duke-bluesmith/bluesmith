<?= $this->extend('layouts/public') ?>
<?= $this->section('main') ?>

		<form action="<?= site_url('files/upload') ?>" class="dropzone mb-3" id="files-dropzone"></form>

		<?php if ($files !== []): ?>

		<div class="row">
			<div class="col-sm-8">
				<table class="table table-sm table-striped">
					<thead>
						<tr>
							<th scope="col">Filename</th>
							<th scope="col">Type</th>
							<th scope="col">Size</th>
							<th scope="col">Added</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($files as $file): ?>

						<tr>
							<td><?= $file->filename ?></td>
							<td class="align-middle"><?= $file->type ?></td>
							<td class="align-middle"><?= bytes2human($file->size) ?></td>
							<td class="align-middle"><?= $file->created_at->humanize(); ?></td>
							<td>

								<?= form_open() ?>
									<input type="hidden" name="_method" value="DELETE" />
									<input type="hidden" name="file_id" value="<?= $file->id ?>" />

									<button class="btn btn-link btn-sm text-danger" type="submit"><i class="fas fa-minus-circle"></i></button>
								<?= form_close() ?>

							</td>
						</tr>

						<?php endforeach; ?>
					</tbody>
				</table>

			</div>
		</div>

		<?php endif; ?>
		<?= form_open() ?>
			<?php if ($files === [] && ! $job->stage->required): ?>

			<p>If you do not have the files available or need to submit them in an alternate format, please indicate below:</p>
			<div class="form-check">
				<input class="form-check-input" name="accept" type="checkbox" value="1" id="acceptCheck">
				<label class="form-check-label" for="acceptCheck">
					I will provide the files later.
				</label>
			</div>

			<?php endif; ?>

			<hr>

			<input class="btn btn-success mt-3" type="submit" name="complete" value="<?= $buttonText ?>">

		<?= form_close() ?>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>

	<?= view(config('Files')->views['dropzone']) ?>

<?= $this->endSection() ?>
