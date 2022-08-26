<?php
session_start();
require 'dbdetails.php';
require 'formvalidationhelper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = htmlspecialchars($_POST["username"]);
	$password = htmlspecialchars($_POST["password"]);

	if(!isValidUsername($username)) {
		echo "<p>Username should begin with a letter and should have a minimum length of 6 and should not contain more than 64 characters.</p>";
		echo "<p>Go to <a href='index.php'>Home</a></p>";
		exit();
	}
	if(!isValidPassword($password)) {
		echo "<p>Password should contain at least one lowercase character, at least one uppercase character, at least one digit and should have a minimum length of eight.</p>";
		echo "<p>Go to <a href='index.php'>Home</a></p>";
		exit();
	}
	$dbconn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

	if (!$dbconn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM user WHERE name='$username'";
	$result = mysqli_query($dbconn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$hash = $row["hash"];
		if (password_verify($password, $hash)) {
			$user_id = $row["id"];
			$_SESSION["user_id"] = $user_id;
			$_SESSION["user_name"] = $row["name"];
			$_SESSION["logged_in"] = true;
			header("Location: dashboard.php");
			
		}else{
			echo "Password is not matching<br></br><a href='index.php'> Login Again</a>";
		}
	}else{
		echo "Username doesnot exist<br></br><a href='index.php'> Login Again</a>";
	}
	mysqli_free_result($result);
	mysqli_close($dbconn);
}
?>
<html lang="en">
<head>
<title>Login</title>
</head>
<body>
<form action="" method="post">
<label for="username">Username</label><br>
<input type="text" name="username" id="username" required autofocus></input>
</br>
<label for="password">Password</label><br>
<input type="password" name="password" id= "password"required></input>
</br>
<input type="submit" value="Login"></input>
<!--
<label>
<input type="checkbox" checked="checked" name="remember"></input>Remember me
</label>
-->
<!--
</br>
<p>Forgot <a href="#">password?</a></br></p>
-->
<p>Don't have an account? <a href="register.php">Register now</a>.</p>
</form>

</body>
</html>