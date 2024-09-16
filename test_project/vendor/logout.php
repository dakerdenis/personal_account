<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Expire the cookies by setting them with a past expiration date
setcookie('loggedin', '', time() - 3600, "/");
setcookie('name', '', time() - 3600, "/");
setcookie('surname', '', time() - 3600, "/");
setcookie('pinCode', '', time() - 3600, "/");
setcookie('token', '', time() - 3600, "/");

// Redirect to the login page (or index page)
header("Location: /cabinet/index.php");
exit();
