<?php

include_once('cfg.php');
include_once('fetcher/gmapi-data.php');
include_once('fetcher/glue.php');
include_once('fetcher/controllers.php');
include_once('fetcher/functions.php');

$urls = array(
	'/' => 'index',
	'/api' => 'api',
	'/version/([a-z4]+)' => 'version',
	'/release/([a-z4]+)' => 'release',
);



try {
	glue::stick($urls);
} catch (Exception $e) {
	include('fetcher/design/header.php');
	echo '404 - not found';
	include('fetcher/design/footer.php');
}


