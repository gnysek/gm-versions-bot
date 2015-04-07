<?php
header("Content-Type: text/plain");
error_reporting(E_ALL);

include_once('cfg.php');
include_once('fetcher/gmapi-data.php');

//if (php_sapi_name() !== 'cli') {
//	die('access denied');
//}

$rss = array(
	'gmstudio' => 'http://store.yoyogames.com/downloads/gm-studio/update-studio-stable.rss',
	'gmstudiobeta' => 'http://store.yoyogames.com/downloads/gm-studio/update-studio.rss',
	'gmstudioea' => 'http://store.yoyogames.com/downloads/gm-studio-ea/update-studio.rss',
	'gm4win' => 'http://store.yoyogames.com/downloads/gm4win/update.rss',
	'gm4mac' => 'http://store.yoyogames.com/downloads/gm4mac/update.rss',
	#'gm4html5' => 'http://store.yoyogames.com/downloads/gm4html5/update-html5.rss',
);

$final = array();

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$errors = false;

foreach ($rss as $name => $url) {

	curl_setopt($ch, CURLOPT_URL, $url);
	$contents = curl_exec($ch);

	$xml = simplexml_load_string($contents);

	//$xml = @simplexml_load_file($url);
	if (!empty($xml)) {
		/* @var $xml SimpleXMLElement */
		$json = json_encode($xml);
		$data = json_decode($json, TRUE);

		if (!empty($data['channel']['item'])) {
			if (empty($data['channel']['item']['title'])) {
				$i1 = $data['channel']['item'][0];
				$i2 = end($data['channel']['item']);
			} else {
				$i1 = $i2 = $data['channel']['item'];
			}

			$info = (strtotime($i1['pubDate']) > strtotime($i2['pubDate'])) ? $i1 : $i2;

			$final[$name] = array(
				'version' => preg_replace('/[^\d\.]/i', '', $info['title']),
				'released' => $info['pubDate'],
				'releasedUT' => strtotime($info['pubDate']),
			);
			$final[$name]['daysAgo'] = ceil((time() - $final[$name]['releasedUT']) / 86400);
		}
	} else {
		$final[$name] = array(
			'version' => '-',
			'released' => '-',
			'releasedUT' => 0,
			'daysAgo' => -1,
		);
		$errors = true;
	}
}

curl_close($ch);

$old_versions = json_decode(file_get_contents(dirname(__FILE__) . '/result.tmp'), true);

//print_r($old_versions);

/*if (count($final) > 1 && !$errors) {
	if (php_sapi_name() == 'cli') {
		file_put_contents(dirname(__FILE__) . '/result.tmp', json_encode($final));
	} else {
		file_put_contents('result.tmp', json_encode($final));
	}
}*/

// twitter

if (!$errors) {

	require dirname(__FILE__) . '/twitter/twitter.class.php';

	$twitter = null;

	$names = array(
		'gmstudio' => '#GameMaker #Studio (stable)',
		'gmstudiobeta' => '#GameMaker #Studio (beta)',
		'gmstudioea' => '#GameMaker #Studio (EAP)',
		/*
		'gm4html5' => 'GameMaker:HTML5',
		'gm4mac' => 'GameMaker for Mac',
		*/
		'gm4win' => 'GameMaker 8.1 Standard',
	);
	$releaseNotes = array(
		'gmstudio' => 'http://gmapi.gnysek.pl/release/gmstudio',
		'gmstudiobeta' => 'http://gmapi.gnysek.pl/release/gmstudiobeta',
		'gmstudioea' => 'http://gmapi.gnysek.pl/release/gmstudioea',
		'gm4win' => '',
	);

	foreach ($old_versions as $name => $data) {

		if (isset($old_versions[$name]['fetchedByApi'])) {
			$final[$name]['fetchedByApi'] = $old_versions[$name]['fetchedByApi'];
		} else {
			$final[$name]['fetchedByApi'] = $old_versions[$name]['releasedUT'];
		}

		$final[$name]['daysAgo'] = floor((time() - $final[$name]['fetchedByApi']) / 86400);

		if ($final[$name]['version'] == $data['version']) {
			echo $name . ': ' . $data['version'] . ' not changed ' . PHP_EOL;
		} else {
			echo $name . ': ' . $data['version'] . ' -> ' . $final[$name]['version'] . PHP_EOL;
		}

		if (version_compare($data['version'], $final[$name]['version'], '<')) {
			$final[$name]['fetchedByApi'] = time();
			if (empty($twitter) and !empty($CFG)) {
				$twitter = new Twitter($CFG['consumerKey'], $CFG['consumerSecret'], $CFG['accessToken'], $CFG['accessTokenSecret']);
				try {
					$twitter->send($names[$name] . ' v. ' . $final[$name]['version'] . ' is out! ' . $releaseNotes[$name] . ' #yoyogames');
				} catch (Exception $e) {
					echo $e->getMessage() . PHP_EOL;
					file_put_contents('log.txt', $e->getMessage() . PHP_EOL);
				}
			}
			echo 'updated!' . PHP_EOL;
		}
	}

	if (php_sapi_name() == 'cli') {
		file_put_contents(dirname(__FILE__) . '/result.tmp', json_encode($final));
	} else {
		file_put_contents('result.tmp', json_encode($final));
	}

} else {
	echo 'There was some error. Nothing written.';
}
//

echo 'DONE';
