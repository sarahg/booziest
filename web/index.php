<?php

require_once __DIR__.'/../vendor/autoload.php';
$app = new Silex\Application();


/**
 * Dev only - remove for production.
 * @todo this sort of stuff should be in a separate file
 */

/**
 * Front controller needs to return false to serve static files.
 * @see http://silex.sensiolabs.org/doc/web_servers.html
 */
$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
  return false;
}

// Better error messages.
$app['debug'] = true;

/** end dev only **/


// Register the template path.
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__ . '/views'
));


// Front page.
$app->get('/', function () use ($app) {
  return $app['twig']->render('form.html.twig');
});


// User page.
$app->get('/{username}', function ($username) use ($app) {

  // @todo this can't be the right way to load this.
  include( __DIR__.'/../app/Controller/UserController.php');
  $beers = new UserBeerList($username);
  return $app['twig']->render('user.html.twig', array('user_beers_table' => $beers->_table));
});

$app->run();
