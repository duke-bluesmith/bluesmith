<?php
$data = [
	'title'   => '{title}',
	'preview' => '{preview}',
	'contact' => '{contact}',
];

$this->setData($data)->extend('layouts/email', $data);
?>
<?= $this->section('main') ?>

{body}

<?= $this->endSection() ?>
