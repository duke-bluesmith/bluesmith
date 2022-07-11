<?= $this->setVar('action', $job->stage->action->instance)->extend('layouts/public') ?>
<?= $this->section('main') ?>

	<h4>Basic info</h4>

	<form name="update-job" method="post">
		<div class="row">
			<div class="col-sm-8">
				<div class="form-group">
					<label for="name">Job name<span class="badge badge-warning ml-2">Required</span></label>
					<input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Job name" value="<?= old('name', $job->name === 'My New Job' ? '' : $job->name) ?>" required>
					<small id="nameHelp" class="form-text text-muted">A short descriptive name to identify this job.</small>
				</div>
				<div class="form-group">
					<label for="summary">Job description<span class="badge badge-warning ml-2">Required</span></label>
					<input name="summary" type="text" class="form-control" id="icon" aria-describedby="summaryHelp" placeholder="Job summary" value="<?= old('summary', $job->summary) ?>" required>
					<small id="summaryHelp" class="form-text text-muted">A brief summary of this job.</small>
				</div>
			</div>
		</div>

		<input class="btn btn-success" type="submit" name="complete" value="Continue">
	</form>

</div>

<?= $this->endSection() ?>
