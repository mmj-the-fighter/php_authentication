<?php
//logout.phps
session_start();
if( isset($_SESSION["logged_in"]))
{
 session_unset();
 session_destroy();
 echo "You have successfully logged out.";
 header('Refresh: 3; URL=index.php');
}else{
 echo "You are not logged in<br>";
}
?>







  
