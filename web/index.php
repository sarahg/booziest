<?php

require_once __DIR__.'/../vendor/autoload.php';
$app = new Silex\Application();


/** Dev only - remove for production. **/

/**
 * Front controller needs to return false to serve static files.
 * @see http://silex.sensiolabs.org/doc/web_servers.html
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
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
  return $app['twig']->render('form.html.twig', array('username' => $username));
});


// User page.
$app->get('/{username}', function ($username) use ($app) {

  // @todo this isn't the right way to load this.
  include( __DIR__.'/../app/Controller/UserController.php');
  $user = new User($username);

  return $app['twig']->render('user.html.twig', array('user' => $user));
});

$app->run();
