<?php
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "master_ewaste");

$mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);
if(mysqli_connect_errno()){
	die("ERROR");
} 
//("Connection Successful");


?>