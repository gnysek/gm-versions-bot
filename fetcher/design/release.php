<?php include('fetcher/design/header.php'); ?>
<?php global $resultFile; ?>
<?php global $gmapis; ?>

<?php if (array_key_exists($version[1], $gmapis) and array_key_exists($version[1], $resultFile)): ?>
	<h1>Latest update for: <?php echo $gmapis[$version[1]]['name']; ?></h1>

	<p><?php echo get_version($version[1], $resultFile); ?></p>
	<p>
		<a class="btn" href="<?php echo $gmapis[$version[1]]['notes']; ?>" target="_blank">Release Notes for <?php echo $resultFile[$version[1]]['version']; ?> / YYG website</a>
		<?php echo get_download($version[1], $gmapis, $resultFile); ?>
	</p>

<?php else: ?>
	<p>There's no GM version like this.</p>
<?php endif; ?>

<?php include('fetcher/design/footer.php'); ?>