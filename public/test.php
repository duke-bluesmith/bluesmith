<?php
$filename = '/srv/web/bluesmith-ci4.oit.duke.edu/writable/logs/test.txt';
$test = realpath($filename);
var_dump($test);

if (! is_writeable($filename) )
	die("you shall not pass");
	
$test = file_put_contents($filename, "HELLO WORLD");
var_dump($test);
?>

hello
