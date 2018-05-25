<?php include('fetcher/design/header.php'); ?>
<?php global $resultFile; ?>
<?php global $gmapis; ?>

<?php include_once('fetcher/design/twitter-timeline.php'); ?>

<h1>GameMaker updates bot</h1>

<h2 style="color: #039d5b;">GameMaker Studio 2</h2>

<?php $name = 'gm2ide'; $data = $gmapis[$name]; ?>
<h4>
	<a href="<?php echo URL; ?>release/<?php echo $name; ?>">GameMaker Studio 2 IDE</a>
</h4>
<p><strong>Windows & OS X</strong>: <?php echo get_version($name, $resultFile, false); ?></p>
<a class="btn btn-primary btn-small" href="<?php echo URL; ?>release/<?php echo $name; ?>">Check Release notes or get download link for GMS2 IDE &raquo;</a>

<?php $name = 'gm2runtime'; $data = $gmapis[$name]; ?>
<h4>
	<a href="<?php echo URL; ?>release/<?php echo $name; ?>"><?php echo $data['name']; ?></a> (downloads from IDE only)
</h4>
<p><?php echo get_version($name, $resultFile, false); ?></p>
<a class="btn btn-primary btn-small" href="<?php echo URL; ?>release/<?php echo $name; ?>">Check release notes for GMS2 runtime</a>
<hr>
<a href="https://help.yoyogames.com/hc/en-us/articles/231719448-RoadMap" target="_blank" class="btn btn-success btn-small">See roadmap for GameMaker Studio 2</a>

<div style="clear: both;"></div>
<h2 style="color: #039d5b;">Older versions</h2>

<?php foreach ($gmapis as $name => $data): ?>
	<?php if (in_array($name, array('gm2ide', 'gm2runtime'))) continue; ?>
	<div class="row">
		<div class="span4">
			<h4 style="margin: 0px;"><a href="<?php echo URL; ?>release/<?php echo $name; ?>"><?php echo $data['name']; ?></a></h4>
			<?php if (preg_match('/gm4/', $name)): ?><small>[ ARCHIVED ]</small><?php endif; ?>
		</div>
		<div class="span4">
			<?php echo get_version($name, $resultFile); ?>
		</div>
		<div class="span4">
			<a class="btn btn-success" href="<?php echo URL; ?>release/<?php echo $name; ?>">Details <?php if (get_download($name, $gmapis, $resultFile, true)): ?>&amp; Download<?php endif; ?></a>
		</div>
	</div>
	<hr>
<?php endforeach; ?>

<h3>...For developers and webmasters</h3>

<p>If you want to use this data on your website / in your application, please check <a href="/api"><u>API Docs</u></a>.</p>

<?php include('fetcher/design/footer.php'); ?>
