<?php date_default_timezone_set('UTC'); ?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booziest</title>
    <link rel="stylesheet" href="css/app.min.css" />
    <link href='http://fonts.googleapis.com/css?family=Rubik+One' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="bower_components/fontawesome/css/font-awesome.min.css" />
    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/favicons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/img/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="msapplication-TileImage" content="/img/favicons/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
  </head>
  <body>

    <div class="row">
      <div class="large-6 medium-12 columns">
        <h1 class="left"><a href="/">Booziest</a></h1>
      </div>
      <div class="large-6 medium-12 columns" class="right">
        <h2>Your Untappd checkins, sorted by ABV</h2>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
        <div class="panel radius">
	        <div class="row">
	        	<div class="large-5 medium-5 columns search-form">
              <form id="search-user">
                <input class="left" id="username" type="text" placeholder="Enter your Untappd username">
                <input type="submit" class="right small round button" value="Go">
              </form>
	    	    </div>
            <div class="large-12 medium-12 columns" id="query-results"></div>
					</div>
      	</div>
        <p>
          <a href="http://untappd.com"><img id="untappd-logo" height="19" width="80" src="img/pbu_40_black.png" alt="Powered by Untappd"></a>
          <small class="copyright">Copyright &copy; <?php echo date('Y'); ?> <a href="http://sarahgerman.com">Sarah German</a>.&nbsp;
          <span class="github">View source code on <a href="https://github.com/sarahg/booziest">Github.<i class="fa fa-github"></i></a></span></small>
        </p>
        <div id="dude-wrapper" class="right"></div>
      </div>
    </div>
    <!-- @todo maybe add social share crap -->

    <script src="js/app.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59765031-1', 'auto');
  ga('send', 'pageview');
</script>
