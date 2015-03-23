<?php
/**
 * @file app.php
 */

include('keys.inc');
include('classes/booziest.php');
include('classes/friends.php');

// @todo allow $_GET for sharing links to result page
$username = $_POST['username'];
$booziest = new Booziest($username);

// Load friends.
if (!empty($booziest->_userPals)) {
  $pals = new Friends($username, $booziest);
}

// @todo pull the render out of Booziest class

?>
