<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>GameMaker products latest versions API</title>
	<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.0/cyborg/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<!--	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>-->
	<style>
		hr {
			margin: 10px 0px;
		}
		.container-fluid {
			padding: 0px;
		}
		small {
			font-size: 10px;
			line-height: 12px;
		}
		.alert {
			margin-bottom: 5px;
		}
	</style>
<?php $class = @get_called_class(); ?>
<?php if ($class == 'release'): ?>
<?php global $gmapis; ?>
<?php global $resultFile; ?>
<?php if (array_key_exists($version[1], $gmapis) and array_key_exists($version[1], $resultFile)): ?>
	<meta property="twitter:card" content="summary"/>
	<meta name="twitter:site" content="@GameMakerUpdate"/>
	<meta name="twitter:title" content="<?php echo $gmapis[$version[1]]['name']; ?> <?php echo $resultFile[$version[1]]['version']; ?>"/>
	<meta name="twitter:description" content="View release notes and download <?php echo $resultFile[$version[1]]['version']; ?> update directly."/>
	<?php if (!empty($gmapis[$version[1]]['image'])): ?><meta name="twitter:image" content="<?php echo URL . 'img/'. $gmapis[$version[1]]['image']; ?>"/><?php endif; ?>
<?php endif; ?>
<?php endif; ?>
</head>
<body style="padding-top: 60px;">

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a href="/" class="brand">GMAPI</a>

			<div id="main-menu" class="nav-collapse collapse">
				<ul id="main-menu-left" class="nav">
					<li><a href="/">Home</a></li>
					<li><a href="https://twitter.com/GameMakerUpdate" target="_blank">Follow GM Updates bot on Twitter</a></li>
<!--					<li><a href="https://psplusinfo.com/" target="_blank">PlayStation Plus Instant Games Collection</a></li>-->
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container">
<?php include('adsense.php'); ?>
