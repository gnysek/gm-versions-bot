<?php
$url = $_SERVER['REQUEST_URI'];
if (file_exists('result.tmp')) {
    $data = json_decode(file_get_contents('result.tmp'), true);
} else {
    $data = array();
}
include('cfg.php');
include('functions.php');

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
	<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.0/slate/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<!--	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>-->
</head>
<body style="padding-top: 100px;">
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a href="/" class="brand">GMAPI</a>

			<div id="main-menu" class="nav-collapse collapse">
                <ul id="main-menu-left" class="nav">
                    <li><a href="https://twitter.com/GameMakerUpdate">GMAPI on Twitter</a></li>
                </ul>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<h1>GMAPI Bot</h1>
	To get latest versions of GameMaker products, use one of this links:<br/>
	Cron runs every half an hour to update data.<br/>
	<br/>
	Select url with version that you want to fetch:<br/>
	<br/>
				<?php include('cfg.php'); ?>
	<a class="btn btn-small" href="<?php echo URL; ?>version/gm4win">GM:Standard 8.1</a> -
    <?php echo get_version('gm4win', $data); ?><br/><br/>
    <?php /*
				<a href="<?php echo URL; ?>version/gm4mac">Mac</a> - <?php echo get_version('gm4mac', $data); ?><br/><br/>
				<a href="<?php echo URL; ?>version/gm4html5">HTML5</a> - <?php echo get_version('gm4html5', $data); ?><br/><br/>
				*/ ?>
	<a class="btn btn-small" href="<?php echo URL; ?>version/gmstudio">GM:Studio</a> -
    <?php echo get_version('gmstudio', $data); ?><br/><br/>

	<a class="btn btn-small" href="<?php echo URL; ?>version/gmstudioea">GM:Studio</a> -
	<?php echo get_version('gmstudioea', $data); ?><br/><br/>

	<a class="btn btn-small" href="<?php echo URL; ?>version/all">All versions at once</a><br/><br/>
	<hr/>
	Data returned by one of above methods will be a JSON data. Example how to get and what will be returned:<br/>
	<br/>
	<i>&bull; Usage example in PHP [with file_get_contents (slower)]</i>
				<pre>
	$data = json_decode(file_get_contents('<?= URL ?>version/all'), true);
	echo $data['gm4win']['version']; //will output <?php echo $data['gm4win']['version']; ?>
				</pre>
	<br/>
	<i>&bull; Usage example in PHP [with CURL]</i>
				<pre>
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, '<?= URL ?>/version/all');
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
	<hr/>
	<footer id="footer">&copy; 2012 - <?php echo date('Y'); ?> gnysek.pl</footer>
	<p></p>
</div>
</body>
</html>
<?php endif; ?>
