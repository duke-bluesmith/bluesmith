<?php
$data = [
	'title'   => 'Simple Transactional Email',
	'preview' => 'This is preheader text. Some clients will show this text as a preview.',
	'contact' => 'Company Inc, 3 Abbey Road, San Francisco CA 94102',
];

$this->setData($data)->extend('layouts/email', $data);
?>
<?= $this->section('main') ?>

  <td>
	<p>Hi there,</p>
	<p>Sometimes you just want to send a simple HTML email with a simple design and clear call to action. This is it.</p>
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
	  <tbody>
		<tr>
		  <td align="left">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
			  <tbody>
				<tr>
				  <td> <a href="http://htmlemail.io" target="_blank">Call To Action</a> </td>
				</tr>
			  </tbody>
			</table>
		  </td>
		</tr>
	  </tbody>
	</table>
	<p>This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>
	<p>Good luck! Hope it works.</p>
  </td>

<?= $this->endSection() ?>
