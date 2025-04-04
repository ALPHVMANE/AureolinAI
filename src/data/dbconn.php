<?php
require_once 'dbconfig.php';
try 
{
    $connection =
    new PDO ("mysql:host=$host;dbname=$dbname",$user,$pass);
    echo "You are connected to $dbname database <br/>";
    if(!mysqli_connect_errno())
        header('location:home.php');
    else
        header('location:errorDatabase.php');

} catch (PDOException $e) 
{
    
    echo "Error Message: ".$e;
}        