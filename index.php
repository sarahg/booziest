<!doctype html>

<!-- @todo add favicon -->

<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booziest</title>
    <link rel="stylesheet" href="css/app.css" />
    <link href='http://fonts.googleapis.com/css?family=Rubik+One' rel='stylesheet' type='text/css'>
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>

    <div class="row">
      <div class="large-12 columns">
        <h1 class="left"><a href="/">Booziest</a></h1>
        <h2 class="right">Your Untappd checkins, sorted by ABV</h2>
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

        <a href="http://untappd.com"><img id="untappd-logo" height="19" width="80" src="img/pbu_40_black.png" alt="Powered by Untappd"></a>
        <div id="dude-wrapper" class="right"></div>
      </div>
    </div>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/vendor/stupidtable.min.js"></script>
    <script src="js/app.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>

<!-- @todo add analytics -->
<!-- @todo add copyright/link/github -->
