<?php
$servername = "localhost";
$username = "root";
$password = "";
$database="nanoshel_rnd";

// Create connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
?>