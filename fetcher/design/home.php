<?php include('fetcher/design/header.php'); ?>
<?php global $resultFile; ?>
<?php global $gmapis; ?>

<h1>GameMaker updates bot</h1>

<?php include_once('fetcher/design/twitter-timeline.php'); ?>

<?php foreach ($gmapis as $name => $data): ?>
	<h3>
		<a href="<?php echo URL; ?>release/<?php echo $name; ?>"><?php echo $data['name']; ?></a>
		<a class="btn btn-success" href="<?php echo URL; ?>release/<?php echo $name; ?>">Details <?php if (get_download($name, $gmapis, $resultFile, true)): ?>&amp; Download<?php endif; ?></a>
	</h3>
	<?php echo get_version($name, $resultFile); ?>
<?php endforeach; ?>

<hr>
<h3>For developers and webmasters</h3>

<p>If you want to use this data on your website / in your application, please check <a href="/api"><u>API Docs</u></a>.</p>

<?php include('fetcher/design/footer.php'); ?>
