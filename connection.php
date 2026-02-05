<?php
$theserver = 'localhost';
$theuser = 'root';
$thepassword = '';  
$thedatabase = 'projekt_web';
$port = 3308; 

$conn = mysqli_connect($theserver, $theuser, $thepassword, $thedatabase, $port);
if (!$conn) {
    die("Lidhja me databazën dështoi: " . mysqli_connect_error());
}
?>
