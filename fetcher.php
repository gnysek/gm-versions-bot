<?php

chdir(dirname(__FILE__));

header("Content-Type: text/plain");
error_reporting(E_ALL);
set_time_limit(60);
ini_set('default_socket_timeout', 5);

include_once('cfg.php');
include_once('fetcher/gmapi-data.php');

//if (php_sapi_name() !== 'cli') {
//	die('access denied');
//}

$rss = array(
	'gm2ide'       => 'http://gms.yoyogames.com/update-win.rss',
	#'gm2idemac'    => 'http://gms.yoyogames.com/update-mac.rss',
	'gm2runtime'   => 'http://gms.yoyogames.com/Zeus-Runtime.rss',
    'gm2ide-beta'       => 'http://gms.yoyogames.com/update-win-Beta.rss',
	'gm2runtime-beta'   => 'http://gms.yoyogames.com/Zeus-Runtime-Beta.rss',
	'gmstudio'     => 'https://store.yoyogames.com/downloads/gm-studio/update-studio-stable.rss',
	'gmstudiobeta' => 'https://store.yoyogames.com/downloads/gm-studio/update-studio.rss',
	'gmstudioea'   => 'https://store.yoyogames.com/downloads/gm-studio-ea/update-studio-ea.rss',
	'gm4win'       => '',
	'gm4mac'       => '',
	#'gm4win' => 'http://store.yoyogames.com/downloads/gm4win/update.rss',
	#'gm4mac' => 'http://store.yoyogames.com/downloads/gm4mac/update.rss',
	#'gm4html5' => 'http://store.yoyogames.com/downloads/gm4html5/update-html5.rss',
);
echo 'PHP ' . phpversion() . PHP_EOL;

$final = array();

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$errors = false;

foreach ($rss as $name => $url) {

	if (empty($url)) {
		echo 'Skipping ' . $name . ' - rss path removed, probably inactive.' . PHP_EOL;
		continue;
	}

	curl_setopt($ch, CURLOPT_URL, $url);
	$contents = curl_exec($ch);

	$xml = @simplexml_load_string($contents);

	//$xml = @simplexml_load_file($url);
	if (!empty($xml)) {
		/* @var $xml SimpleXMLElement */
		$json = json_encode($xml);
		$old_data = json_decode($json, TRUE);

		if (!empty($old_data['channel']['item'])) {
			if (empty($old_data['channel']['item']['title'])) {
				$i1 = $old_data['channel']['item'][0];
				$i2 = end($old_data['channel']['item']);
			} else {
				$i1 = $i2 = $old_data['channel']['item'];
			}

			$info = (strtotime($i1['pubDate']) > strtotime($i2['pubDate'])) ? $i1 : $i2;

			$final[$name] = array(
				'version'      => preg_replace('/[^\d\.]/i', '', $info['title']),
				'released'     => $info['pubDate'],
				'releasedUT'   => strtotime($info['pubDate']),
				'fetchedByApi' => time(),
			);
			$final[$name]['daysAgo'] = ceil((time() - $final[$name]['releasedUT']) / 86400);
		}
	} else {
		echo 'Can\'t read ' . $name . ' RSS' . PHP_EOL;
		foreach (libxml_get_errors() as $error) {
			echo "\t(", $error->message . ')' . PHP_EOL;
		}
	}
}

echo PHP_EOL . '-- FETCHED, parse -- ' . PHP_EOL . PHP_EOL;

curl_close($ch);

$old_versions = json_decode(file_get_contents(dirname(__FILE__) . '/result.tmp'), true);

$old_versions['gm4win']['version'] = '8.1.141';

// twitter

if (!$errors) {

	require dirname(__FILE__) . '/twitter/OAuth.php';
	require dirname(__FILE__) . '/twitter/twitter.class.php';

	$twitter = null;

    $names = array(
        'gm2ide'          => '#GameMakerStudio2 IDE (stable)',
        'gm2runtime'      => '#GameMakerStudio2 Runtime (stable)',
        'gm2ide-beta'     => 'GMS2 IDE (beta)',
        'gm2runtime-beta' => 'GMS2 Runtime (beta)',
        'gmstudio'        => '#GameMaker #Studio (stable)',
        'gmstudiobeta'    => '#GameMaker #Studio (beta)',
        'gmstudioea'      => '#GameMaker #Studio (EAP)',
        'gm4html5'        => 'GameMaker:HTML5',
        'gm4mac'          => 'GameMaker for Mac',
        'gm4win'          => 'GameMaker 8.1 Standard',
    );
    $releaseNotes = array(
        'gm2ide'          => 'https://gmapi.gnysek.pl/release/gm2ide',
        'gm2runtime'      => 'https://gmapi.gnysek.pl/release/gm2runtime',
        'gm2ide-beta'     => 'https://gmapi.gnysek.pl/release/gm2ide-beta',
        'gm2runtime-beta' => 'https://gmapi.gnysek.pl/release/gm2runtime-beta',
        'gmstudio'        => 'https://gmapi.gnysek.pl/release/gmstudio',
        'gmstudiobeta'    => 'https://gmapi.gnysek.pl/release/gmstudiobeta',
        'gmstudioea'      => 'https://gmapi.gnysek.pl/release/gmstudioea',
        'gm4win'          => '',
        'gm4mac'          => '',
    );

	foreach ($old_versions as $name => $old_data) {

		if (!array_key_exists($name, $final)) {
			$final[$name] = $old_versions[$name];
		}

		if (!empty($old_versions[$name]['fetchedByApi'])) {
			$final[$name]['fetchedByApi'] = $old_versions[$name]['fetchedByApi'];
		} else {
			$final[$name]['fetchedByApi'] = $old_versions[$name]['releasedUT'];
		}

		if ($final[$name]['version'] == $old_data['version']) {
			echo $name . ': ' . $old_data['version'] . ' not changed ' . PHP_EOL;
		} else {
			echo $name . ': ' . $old_data['version'] . ' -> ' . $final[$name]['version'] . PHP_EOL;
		}

		if (version_compare($old_data['version'], $final[$name]['version'], '<')) {
			$final[$name]['fetchedByApi'] = time();
			if (!empty($CFG)) {
				$twitter = new Twitter($CFG['consumerKey'], $CFG['consumerSecret'], $CFG['accessToken'], $CFG['accessTokenSecret']);
				try {
					$twitter->send($names[$name] . ' v. ' . $final[$name]['version'] . " is out! \nCheck release notes & download on " . $releaseNotes[$name] . ' #yoyogames #GameMakerStudio2');
				} catch (Exception $e) {
					echo $e->getMessage() . PHP_EOL;
					file_put_contents('log.txt', $e->getMessage() . PHP_EOL);
				}
			}
			echo 'updated!' . PHP_EOL;
		}
	}

	foreach ($final as $name => $value) {
		$_date1 = new DateTime(date('Y-m-d', $final[$name]['fetchedByApi']));
		$_date2 = new DateTime();
		$dDiff = $_date1->diff($_date2);

		$final[$name]['daysAgo'] = $dDiff->days;
	}

	if (php_sapi_name() == 'cli') {
		echo 'Saved to file [CLI]' . PHP_EOL;
		file_put_contents(dirname(__FILE__) . '/result.tmp', json_encode($final));
	} else {
		echo 'Saved to file [Browser]' . PHP_EOL;
		file_put_contents('result.tmp', json_encode($final));
	}

} else {
	echo 'There was some error. Nothing written.';
}
//

echo 'DONE';
