
		<?= form_open('jobs/charges/' . $job->id) ?>
			<input type="hidden" name="_method" value="DELETE" />
			<input type="hidden" name="charge_id" value="<?= $charge->id ?>" />

			<button class="btn btn-link btn-sm text-danger" type="submit"><i class="fas fa-minus-circle"></i></button>
		<?= form_close() ?>
