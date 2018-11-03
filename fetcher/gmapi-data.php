<?php

if (file_exists('result.tmp')) {
	$resultFile = json_decode(file_get_contents('result.tmp'), true);
} else {
	$resultFile = array();
}

$gmapis = array(
	'gm2ide' => array(
		'name' => 'GMS 2.x IDE (Windows/Mac)',
		'notes' => 'https://gms.yoyogames.com/ReleaseNotes.html',
		'rss' => 'https://gms.yoyogames.com/update-win.rss',
		'download' => 'https://gms.yoyogames.com/GameMakerStudio-Installer-%s.exe',
		'desc' => 'IDE - application in which you can project games using GML or Drag\'n\'drop.',
		'image' => 'gms2.png',
		'enabled' => true,
	),
	// 'gm2idemac' => array(
	// 	'name' => 'GMS 2.x IDE (Mac)',
	// 	'notes' => 'https://gms.yoyogames.com/ReleaseNotes.html',
	// 	'rss' => 'https://gms.yoyogames.com/update-mac.rss',
	// 	'download' => 'https://gms.yoyogames.com/GameMakerStudio2-%s.pkg',
	// 	'desc' => 'IDE - application in which you can project games using GML or Drag\'n\'drop.',
	// 	'image' => 'gms2.png',
	// 	'enabled' => true,
	// ),
	'gm2runtime' => array(
		'name' => 'GMS 2.x runtime',
		'notes' => 'https://gms.yoyogames.com/release-notes-runtime.html',
		'rss' => 'https://gms.yoyogames.com/Zeus-Runtime.rss',
		'desc' => 'Runtime - a tool used by IDE to compile a game. May be released independently to only fix bugs in compiled games.',
		'image' => 'gms2.png',
		'enabled' => true,
	),
    'gm2ide-beta' => array(
        'name' => 'GMS 2.x IDE (Windows/Mac) Beta',
        'notes' => 'https://gms.yoyogames.com/ReleaseNotes-Beta.html',
        'rss' => 'https://gms.yoyogames.com/update-win-Beta.rss',
        'download' => 'https://gms.yoyogames.com/GameMakerStudio-Installer-%s.exe',
        'desc' => 'IDE - application in which you can project games using GML or Drag\'n\'drop.',
        'image' => 'gms2.png',
        'enabled' => true,
    ),
    'gm2runtime-beta' => array(
        'name' => 'GMS 2.x runtime Beta',
        'notes' => 'https://gms.yoyogames.com/release-notes-runtime-Beta.html',
        'rss' => 'https://gms.yoyogames.com/Zeus-Runtime-Beta.rss',
        'desc' => 'Runtime - a tool used by IDE to compile a game. May be released independently to only fix bugs in compiled games.',
        'image' => 'gms2.png',
        'enabled' => true,
    ),
	'gmstudio' => array(
		'name' => 'GM:Studio 1.4.x Stable',
		'notes' => 'https://store.yoyogames.com/downloads/gm-studio/release-notes-studio.html',
		'rss' => 'https://store.yoyogames.com/downloads/gm-studio/update-studio-stable.rss',
		'download' => 'http://store.yoyogames.com/downloads/gm-studio/GMStudio-Installer-%s.exe',
		'image' => 'gms1.png',
		'enabled' => true,
	),
	'gmstudiobeta' => array(
		'name' => 'GM:Studio 1.4.x Beta',
		'notes' => 'https://store.yoyogames.com/downloads/gm-studio/release-notes-studio.html',
		'rss' => 'https://store.yoyogames.com/downloads/gm-studio/update-studio.rss',
		'download' => 'http://store.yoyogames.com/downloads/gm-studio/GMStudio-Installer-%s.exe',
		'image' => 'gms1.png',
		'enabled' => true,
	),
	'gmstudioea' => array(
		'name' => 'GM:Studio 1.4.x EAP',
		'notes' => 'https://store.yoyogames.com/downloads/gm-studio-ea/release-notes-studio.html',
		'rss' => 'https://store.yoyogames.com/downloads/gm-studio-ea/update-studio.rss',
		'download' => 'http://store.yoyogames.com/downloads/gm-studio-ea/GMStudio-Installer-%s.exe',
		'image' => 'gms1.png',
		'enabled' => true,
	),
	'gm4win' => array(
		'name' => 'GM 8.x',
		#'notes' => 'http://store.yoyogames.com/downloads/gm4win/release-notes.html',
		'notes' => URL . 'archive/gm4win.html',
		'rss' => 'http://store.yoyogames.com/downloads/gm4win/update.rss',
		#'download' => 'http://store.yoyogames.com/downloads/gm4win/GameMaker-Installer-%s.exe',
		'enabled' => true,
	),
	'gm4mac' => array(
		'name' => 'GM for Mac OS X',
		#'notes' => 'http://store.yoyogames.com/downloads/gm4mac/release-notes.html',
		'notes' => URL . 'archive/gm4mac.html',
		'rss' => 'http://store.yoyogames.com/downloads/gm4mac/update.rss',
		#'download' => 'http://appstore.yoyogames.com/downloads/gm4mac/Game_Maker-%s.dmg',
		'enabled' => true,
	),
);
