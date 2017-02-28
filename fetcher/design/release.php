<?php include('fetcher/design/header.php'); ?>
<?php global $resultFile; ?>
<?php global $gmapis; ?>
<p></p>
<?php #include_once('fetcher/design/twitter-timeline.php'); ?>

<p style="line-height: 28px;" class="text-center">
	<?php foreach ($gmapis as $name => $data): ?>
		<a class="btn btn-small" href="<?php echo URL; ?>release/<?php echo $name; ?>"><?php echo $data['name']; ?></a>
	<?php endforeach; ?>
</p>

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
			</h4>
			<iframe src="<?php echo $gmapis[$version[1]]['notes']; ?>" frameborder="0"
					style="width: 100%; height: 600px; background: white;"></iframe>
		<?php else: ?>
		<div style="line-height: 40px;">
			<p>No release notes for this product.</p>
		</div>
		<?php endif; ?>

<?php else: ?>
	<p>There's no GM version like this.</p>
<?php endif; ?>

<?php include('fetcher/design/footer.php'); ?>
