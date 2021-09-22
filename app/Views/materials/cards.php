
<!-- Card deck -->
<div class="card-deck">

<?php foreach ($materials as $material): ?>

	<?= view('materials/display', ['material' => $material]) ?>

<?php endforeach; ?>

</div>
