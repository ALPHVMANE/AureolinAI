<?php
$servername = "localhost";
$username = "Tim";
$password = "admin";
$dbname = "aureolin_test";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>