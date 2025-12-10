<?php 
$server = "localhost";
$username = "root";
$password = "";
$database = "technova";

$connection = mysqli_connect($server,$username,$password,$database) or die("Database connection Fail");
$config["app_url"] = "https://technovatechnologies.com/";