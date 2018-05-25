<?php include('fetcher/design/header.php'); ?>
<?php global $resultFile; ?>
<?php global $gmapis; ?>

<p>
	<span class="pull-right">
	<small><strong>Archived</strong></small><br>
	<?php foreach (array('gm4win', 'gm4mac') as $name): ?>
		<a class="btn btn-small" href="<?php echo URL; ?>release/<?php echo $name; ?>"><?php echo $gmapis[$name]['name']; ?></a>
	<?php endforeach; ?>
	</span>

	<small><strong>GameMaker Studio 2</strong></small><br>
	<?php foreach (array('gm2ide', 'gm2runtime') as $name): ?>
		<a class="btn btn-small" href="<?php echo URL; ?>release/<?php echo $name; ?>"><?php echo $gmapis[$name]['name']; ?></a>
	<?php endforeach; ?><br>
	<small><strong>GameMaker Studio 1.x</strong></small><br>
	<?php foreach (array('gmstudio', 'gmstudiobeta', 'gmstudioea') as $name): ?>
		<a class="btn btn-small" href="<?php echo URL; ?>release/<?php echo $name; ?>"><?php echo $gmapis[$name]['name']; ?></a>
	<?php endforeach; ?><br>
</p>

<hr>

<?php if (array_key_exists($version[1], $gmapis) and array_key_exists($version[1], $resultFile)): ?>
	<h3 style="color: #039d5b; margin-bottom: 0px;">Latest update for</h3>
	<h1 style="color: #039d5b; margin-top: 0px;"><?php echo $gmapis[$version[1]]['name']; ?></h1>

	<?php if (!empty($gmapis[$version[1]]['desc'])):?>
		<p><small><em>(<?php echo $gmapis[$version[1]]['desc']; ?></em>)</small></p>
	<?php endif; ?>

	<p><?php echo get_version($version[1], $resultFile, false); ?></p>
		<?php if (!empty($gmapis[$version[1]]['notes'])): ?>
			<p>
				<?php echo get_download($version[1], $gmapis, $resultFile); ?>
			</p>
			<hr>
			<h4 style="color: #039d5b;">
				Release notes
				<a class="btn btn-small" href="<?php echo $gmapis[$version[1]]['notes']; ?>" target="_blank">Open Release Notes
					for <?php echo $resultFile[$version[1]]['version']; ?> directly on YYG website &raquo;</a>

                <?php if ($version[1] == 'gm2runtime'): ?>
                    <small>also, <a href="<?php echo URL; ?>release/gm2runtime" target="_blank">check Release Notes
                        for <strong>GMS2 Runtime</strong> <?php echo $resultFile['gm2runtime']['version']; ?> &raquo;</a></small>
                <?php endif; ?>

			</h4>
			<iframe src="<?php echo $gmapis[$version[1]]['notes']; ?>" frameborder="0"
					style="width: 100%; height: 1800px; background: white;"></iframe>
		<?php else: ?>
		<div style="line-height: 40px;">
			<p>No release notes for this product.</p>
		</div>
		<?php endif; ?>

<?php else: ?>
	<p>There's no GM version like this.</p>
<?php endif; ?>

<?php include('fetcher/design/footer.php'); ?>
