<?php
require_once('functions.php');

$url = $_SERVER['REQUEST_URI'];
$data = json_decode(file_get_contents('result.tmp'), true);

if (preg_match('/version/i', $url)):
	$version = preg_replace('/(.*?)version\//i', '', $url);
	switch ($version) {
		case 'gmstudio':
		case 'gmstudioea':
		#case 'gm4html5':
		#case 'gm4mac':
		case 'gm4win':
			header("Content-Type: text/plain");
			echo json_encode(array($version => $data[$version]));
			break;
		default: echo file_get_contents('result.tmp');
	}
	die();
else:
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>GameMaker products latest versions API</title>
			<style>
				body {font-family: Verdana; font-size: 11px;}
				a {color: green; font-weight: bold;}
				#main {width: 600px; margin: 0 auto;}
			</style>
		</head>
		<body>
			<div id="main">
				To get latest versions of GameMaker products, use one of this links:<br/>
				Cron runs every 12 hours to update data.<br/>
				<br/>
				Select url with version that you want to fetch:<br/>
				<br/>
				<?php include('cfg.php'); ?>
				<a href="<?php echo URL; ?>version/gm4win">GM:Standard 8.1</a> - <?php echo get_version('gm4win', $data); ?><br/><br/>
				<?php /*
				<a href="<?php echo URL; ?>version/gm4mac">Mac</a> - <?php echo get_version('gm4mac', $data); ?><br/><br/>
				<a href="<?php echo URL; ?>version/gm4html5">HTML5</a> - <?php echo get_version('gm4html5', $data); ?><br/><br/>
				*/ ?>
				<a href="<?php echo URL; ?>version/gmstudio">GM:Studio</a> - <?php echo get_version('gmstudio', $data); ?><br/><br/>
				<a href="<?php echo URL; ?>version/gmstudio">GM:Studio 1.3 EAP</a> - <?php echo get_version('gmstudioea', $data); ?><br/><br/>
				<a href="<?php echo URL; ?>version/all">All versions at once</a><br/><br/>
				<hr/>
				It will be returned as JSON data:<br/>
				<br/>
				<i>&bull; Usage example in PHP [with CURL]</i>
				<pre>
	$data = json_decode(file_get_contents('http://gmapi.otacon.hekko.pl/version/all'), true);
	echo $data['gm4win']['version']; //will output <?php echo $data['gm4win']['version']; ?>
				</pre>
				<br/>
				<i>&bull; Usage example in PHP [with CURL]</i>
				<pre>
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, 'http://gmapi.otacon.hekko.pl/version/all');
	$data = json_decode(curl_exec($ch), true);
	curl_close($ch);
	echo $data['gm4win']['version']; //will output <?php echo $data['gm4win']['version']; ?>
				</pre>
				<br/>
				<i>&bull; Returned data - example 1 <tt><?php echo URL; ?>version/gm4win</tt></i>
				<?php
				echo '<pre>';
				echo json_encode_pretty(array('gm4win' => $data['gm4win']));
				echo '</pre>';
				?>
				<br/>
				<i>&bull; Returned data - example 2 <tt><?php echo URL; ?>version/all</tt></i>
				<?php
				echo '<pre>';
				echo json_encode_pretty($data);
				echo '</pre>';
				?>
				&copy; 2012 - <?php echo date('Y'); ?> gnysek.pl
			</div>
		</body>
	</html>
<?php endif; ?>
