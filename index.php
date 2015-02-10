<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>booziest</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>

    <div class="row">
      <div class="large-12 columns">
        <h1>booziest</h1>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
      	<div class="panel">
	        <h2>Beers by ABV</h2>
	        <div class="row">
	        	<div class="large-4 medium-4 columns">
	    		    <p>Enter your username below.</p>
              <input type="text" placeholder="Username">
              <input type="submit" class="small round button" value="Go">
	    	    </div>
	        	<div class="large-8 medium-8 columns">
	            <?php include_once('includes/app.php'); ?>
            </div>
					</div>
      	</div>

        <img src="img/pbu_40_black.png" class="right">

      </div>
    </div>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
