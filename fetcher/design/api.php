<?php include('fetcher/design/header.php'); ?>
<?php global $resultFile; ?>
<?php global $gmapis; ?>

<h3>For developers and webmasters</h3>

<p>If you want to display latest version on your site, you can use our JSON file to display data you need.
	To save our transfer it's reccomended that you also create a cronjob task, which is downloading that file
	for example every 30 minutes to your server,
	and you use that cached file to display info. It will also make your website work faster.</p>

<p>If you got questions, OR USED THIS API please contact me at: <strong>gny<span style="display: none;">[antispam]</span>sek (at) gmail (dot) com</strong>
</p>

<p>To get latest versions of GameMaker products, use one of this links:</p>

<?php foreach ($gmapis as $name => $data): ?>
	<a class="btn btn-small" href="<?php echo URL; ?>version/<?php echo $name; ?>"><?php echo $data['name']; ?></a>
<?php endforeach; ?>
<a class="btn btn-small" href="<?php echo URL; ?>version/all">All versions at once</a>

<hr/>

Data returned by one of above methods will be a JSON data. Example how to get and what will be returned:<br/>
<br/>
<i>&bull; Usage example in PHP [with file_get_contents (slower)]</i>
<pre>
	$resultFile = json_decode(file_get_contents('<?= URL ?>version/all'), true);
	echo $resultFile['gm4win']['version']; //will output <?php echo $resultFile['gm4win']['version']; ?>
				</pre>
<br/>
<i>&bull; Usage example in PHP [with CURL]</i>
<pre>
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, '<?= URL ?>/version/all');
	$resultFile = json_decode(curl_exec($ch), true);
	curl_close($ch);
	echo $resultFile['gm4win']['version']; //will output <?php echo $resultFile['gm4win']['version']; ?>
				</pre>
<br/>
<i>&bull; Returned data - example 1 <tt><?php echo URL; ?>version/gm4win</tt></i>
<?php
echo '<pre>';
echo json_encode_pretty(array('gm4win' => $resultFile['gm4win']));
echo '</pre>';
?>
<br/>
<i>&bull; Returned data - example 2 <tt><?php echo URL; ?>version/all</tt></i>
<?php
echo '<pre>';
echo json_encode_pretty($resultFile);
echo '</pre>';
?>


<?php include('fetcher/design/footer.php'); ?>
