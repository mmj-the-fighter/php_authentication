
<?php

function xform($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function xform2($data) {
  $data = trim($data);
  $data = stripslashes($data);
  return $data;
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
	}
	echo "<script>console.log('{$output}');</script>";
}

function isValidPassword($password)
{
	if(strlen($password) < 8) {
		return false;
	}
	if(!preg_match("@[A-Z]@", $password)) {
		return false;
	}
	if(!preg_match("@[a-z]@", $password)) {
		return false;
	}
	if(!preg_match("@[0-9]@", $password)) {
		return false;
	}	
	return true;
}

function isValidUsername($username){
	$pattern  = "/^[A-Za-z][A-Za-z0-9_]{5,63}$/";
	return (preg_match($pattern, $username)) ? true : false;
}


?>
