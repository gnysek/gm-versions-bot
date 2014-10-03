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
        case 'gmstudiobeta':
        case 'gmstudioea':
            #case 'gm4html5':
            #case 'gm4mac':
        case 'gm4win':
            header("Content-Type: text/plain");
            echo json_encode(array($version => $data[$version]));
            break;
        default:
            echo file_get_contents('result.tmp');
    }
    die();
else:
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>GameMaker products latest versions API</title>
        <link href="//netdna.bootstrapcdn.com/bootswatch/2.3.0/slate/bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <!--	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>-->
    </head>
    <body style="padding-top: 100px;">
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a href="/" class="brand">GMAPI</a>

                <div id="main-menu" class="nav-collapse collapse">
                    <ul id="main-menu-left" class="nav">
                        <li><a href="https://twitter.com/GameMakerUpdate" target="_blank">GMAPI on Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="pull-right" style="width: 400px; height: 400px;">
            <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/GameMakerUpdate"
               data-widget-id="518034510445678593">Tweety na temat @GameMakerUpdate</a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + "://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");</script>
        </div>

        <h1>GMAPI Bot</h1>

        <p>Every half an hour we check for new GM versions.
            If new version of GameMaker product is released, it will be posted on <a href="https://twitter.com/GameMakerUpdat" target="_blank">twitter</a> and here:</p>

        <h3>GM:Studio 1.x <a class="btn"
                             href="http://store.yoyogames.com/downloads/gm-studio/release-notes-studio.html">Release
                Notes</a></h3>
        <?php echo get_version('gmstudio', $data); ?>

        <h3>GM:Studio 1.x beta <a class="btn"
                                  href="http://store.yoyogames.com/downloads/gm-studio/release-notes-studio.html">Release
                Notes</a></h3>
        <?php echo get_version('gmstudiobeta', $data); ?>

        <h3>GM:Studio 1.3 EAP <a class="btn"
                                 href="http://store.yoyogames.com/downloads/gm-studio-ea/release-notes-studio.html">Release
                Notes</a></h3>
        <?php echo get_version('gmstudioea', $data); ?>

        <h3>GM Legacy 8.1 <a class="btn" href="http://store.yoyogames.com/downloads/gm4win/release-notes.html">Release
                Notes</a></h3>
        <?php echo get_version('gm4win', $data); ?>

        <hr/>
        <h3>For developers and webmasters</h3>

        <p>If you want to display latest version on your site, you can use our JSON file to display data you need.
            To save our transfer it's reccomended that you also create a cronjob task, which is downloading that file
            for example every 30 minutes to your server,
            and you use that cached file to display info. It will also make your website work faster.</p>

        <p>To get latest versions of GameMaker products, use one of this links:</p>

        <a class="btn btn-small" href="<?php echo URL; ?>version/gm4win">GM:Standard 8.1</a>
        <a class="btn btn-small" href="<?php echo URL; ?>version/gmstudio">GM:Studio</a>
        <a class="btn btn-small" href="<?php echo URL; ?>version/gmstudiobeta">GM:Studio Beta (Unstable)</a>
        <a class="btn btn-small" href="<?php echo URL; ?>version/gmstudioea">GM:Studio 1.3 EAP</a>
        <a class="btn btn-small" href="<?php echo URL; ?>version/all">All versions at once</a>

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
