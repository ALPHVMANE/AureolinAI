<?php
//do not delete this part of code
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../../public/index.php?error=Please login first!");
    exit();
}
//Everything below is deletable
echo "Welcome, " . $_SESSION['username'] . "! <a href='../auth/logout.php'>Logout</a>";
echo " | <a href='../../features/faceid/setupfaceid.php'>Set up Face ID</a>";
?>
