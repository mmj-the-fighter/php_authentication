<?php 
//dashboard.php
session_start();
require 'dbdetails.php';


if( isset($_SESSION["logged_in"]))
{
	$username = $_SESSION["user_name"]; 
	echo "<a href='logout.php'>Logout {$username}</a><br></br>";
}else{
	echo "You are not logged in<br>";
	echo "<p>Go to <a href='index.php'>Home</a></p>";
}

?>