
		<?= form_open('jobs/charges/' . $job->id) ?>
			<input type="hidden" name="_method" value="PUT" />
			<input type="hidden" name="name" value="<?= $name ?>" />
			<input type="hidden" name="amount" value="<?= $amount ?? 0 ?>" />
			<input type="hidden" name="quantity" value="<?= $quantity ?? '' ?>" />

			<button class="btn btn-link btn-sm" type="submit"><i class="fas fa-plus-circle"></i></button>
			<?= $display ?? $name ?>
		<?= form_close() ?>
