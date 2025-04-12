<?php
require_once 'dbconfig.php';
// try 
// {
//     $connection =
//     new PDO ("mysql:host=$host;dbname=$dbname",$user,$pass);
//     echo "You are connected to $dbname database <br/>";
//     if(!mysqli_connect_errno())
//         header('location:home.php');
//     else
//         header('location:errorDatabase.php');

// } catch (PDOException $e) 
// {
    
//     echo "Error Message: ".$e;
// }        
if (!mysqli_connect_errno())
//     echo "User $user is connected successfully to the db $dbname <br/>";
    header('location:../../templates/userProfile.php');
else
//     echo "connection failed: ".mysqli_connect_error()."<br/>";
    header('location:errorDatabase.php');