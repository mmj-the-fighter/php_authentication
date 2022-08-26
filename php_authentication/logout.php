
<?php
//logout.phps
session_start();
session_unset();
session_destroy();
echo "You have successfully logged out.";
header('Refresh: 3; URL=index.php');
?>








  