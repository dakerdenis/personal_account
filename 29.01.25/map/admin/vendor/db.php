<?php


// Create connection
$connection = mysqli_connect('localhost', 'root', '', 'test');

// Check connection
if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>