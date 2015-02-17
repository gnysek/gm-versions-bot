<?php

global $gmapis;
global $resultFile;

header("Content-Type: text/plain");

if (array_key_exists($version[1], $gmapis) and array_key_exists($version[1], $resultFile)) {
	echo json_encode(array($version[1] => $resultFile[$version[1]]));
} elseif ($version[1] == 'all') {
	echo file_get_contents('result.tmp');
} else {
	echo json_encode(array('error' => 'true'));
}
