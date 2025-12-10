<?php 
$servername = "localhost";
$username = "u801822335_tech";  
$password = "vivekVOra32*+";      
$dbname = "u801822335_technova";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: ");
}
?> 