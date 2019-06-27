<?= view('manage/templates/header') ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">items</h1>
</div>

<!-- Content Row -->
<div class="row card-deck">

<?php
foreach ($items as $item):
?>
	<div class="col-md-6 col-lg-4 col-xl-3 mb-4">
		<div class="card h-100">
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><?= anchor('manage/reports/item_summary/' . $item->id, 'One Report') ?></li>
				<li class="list-group-item"><?= anchor('manage/reports/item_listings/' . $item->id, 'Two Report') ?></li>
			</ul>
			<img class="card-img-top" src="" alt="Logo">
			<div class="card-body">
				<h5 class="card-title"><?= $item->name ?></h5>
				<address class="card-text">
					<?= $item->street1 ?><br /> 
					<?= ($item->street2)? $item->street2 . '<br />' : '' ?> 
					<?= $item->city ?>, <?= $item->state ?>  <?= $item->zip ?><br /> 
				</address>
			</div>
			<div class="card-body">
			</div>
			<div class="card-footer">
				<p class="card-text"><small class="text-muted">Last updated <?= $item->getUpdatedAt('humanize') ?></small></p>
				<a href="#" class="card-link btn btn-primary">Edit</a>
				<a href="#" class="card-link">Delete</a>
			</div>
		</div>
	</div>
<?php
endforeach;
?>

</div>

<?= view('manage/templates/footer') ?>
