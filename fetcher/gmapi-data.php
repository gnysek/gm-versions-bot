<?php

if (file_exists('result.tmp')) {
	$resultFile = json_decode(file_get_contents('result.tmp'), true);
} else {
	$resultFile = array();
}

$gmapis = array(
	'gmstudio' => array(
		'name' => 'GM:Studio 1.4.x Stable',
		'notes' => 'http://store.yoyogames.com/downloads/gm-studio/release-notes-studio.html',
		'rss' => 'http://store.yoyogames.com/downloads/gm-studio/update-studio-stable.rss',
		'download' => 'http://store.yoyogames.com/downloads/gm-studio/GMStudio-Installer-%s.exe',
		'enabled' => true,
	),
	'gmstudiobeta' => array(
		'name' => 'GM:Studio 1.4.x Beta',
		'notes' => 'http://store.yoyogames.com/downloads/gm-studio/release-notes-studio.html',
		'rss' => 'http://store.yoyogames.com/downloads/gm-studio/update-studio.rss',
		'download' => 'http://store.yoyogames.com/downloads/gm-studio/GMStudio-Installer-%s.exe',
		'enabled' => true,
	),
	'gmstudioea' => array(
		'name' => 'GM:Studio 1.4.x EAP',
		'notes' => 'http://store.yoyogames.com/downloads/gm-studio-ea/release-notes-studio.html',
		'rss' => 'http://store.yoyogames.com/downloads/gm-studio-ea/update-studio.rss',
		'download' => 'http://store.yoyogames.com/downloads/gm-studio-ea/GMStudio-Installer-%s.exe',
		'enabled' => true,
	),
	'gm4win' => array(
		'name' => 'GM 8.x',
		'notes' => 'http://store.yoyogames.com/downloads/gm4win/release-notes.html',
		'rss' => 'http://store.yoyogames.com/downloads/gm4win/update.rss',
		'download' => 'http://store.yoyogames.com/downloads/gm4win/GameMaker-Installer-%s.exe',
		'enabled' => true,
	),
	'gm4mac' => array(
		'name' => 'GM for Mac OS X',
		'notes' => 'http://store.yoyogames.com/downloads/gm4mac/release-notes.html',
		'rss' => 'http://store.yoyogames.com/downloads/gm4mac/update.rss',
		'enabled' => true,
	),
);
