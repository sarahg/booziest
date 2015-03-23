<?php
/**
 * @file app.php
 */

include('keys.inc');
include('classes/booziest.php');

// @todo allow $_GET for sharing links to result page
$username = $_POST['username'];
new Booziest($username);

?>
