
			<!-- Job-specific staff notes -->
			<div class="staff-notes">
				<div class="row mt-5">
					<div class="col">
						<p class="small text-secondary float-right">Staff notes are not visible to clients</p>
						<h3>Staff Notes</h3>
						<div id="notes" style="max-height: 800px; overflow-x: hidden; overflow-y: scroll;">

							<?php foreach ($job->notes ?? [] as $note): ?>
							<?php if (empty($day) || $day !== $note->created_at->format('n/j/Y')): ?>
							<?php $day = $note->created_at->format('n/j/Y'); ?>
							<div class="row">
								<div class="col-5"><hr></div>
								<div class="col-2"><?= $day ?></div>
								<div class="col-5"><hr></div>
							</div>
							<?php endif; ?>

							<div class="row py-2 border-bottom">
								<div class="col-1">
									<span class="d-inline-block m-1 p-2 rounded-circle text-uppercase text-light bg-dark"
										data-toggle="tooltip" title="<?= $note->user->username ?>"><?= substr($note->user->username, 0, 2) ?></span>
								</div>
								<div class="col-11">
									<h6>
										<span class="badge badge-secondary mr-3"><?= $note->created_at->format('g:i A') ?></span>
										<?= $note->user->getName() ?>
									</h6>
									<div class="note-content">
										<?= $note->getContent(true) ?>
									</div>
								</div>
							</div>
							<?php endforeach; ?>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<form action="<?= site_url('manage/notes/add') ?>" method="post">
							<input type="hidden" name="job_id" value="<?= $job->id ?>" />
							<textarea class="form-control" name="content" placeholder="Markdown content..."></textarea>
							<input class="btn btn-primary float-md-right" type="submit" name="send" value="<?= lang('Pub.send') ?>">
						</form>
					</div>
				</div>
			</div><!-- /.staff-notes -->
