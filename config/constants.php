<?php 

// Getting ROOT Directory URI
$parts = explode('/',$_SERVER['REQUEST_URI']);
$dir = $_SERVER['SERVER_NAME'];
for ($i = 0; $i < count($parts) - 1; $i++) {
	$dir .= $parts[$i] . "/";
}
define('ROOT_DIR', $dir);

