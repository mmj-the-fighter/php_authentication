
<?php
//register.php
session_start();
require 'dbdetails.php';
require 'formvalidationhelper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = htmlspecialchars($_POST["username"]);
	$password = htmlspecialchars($_POST["password"]);
	$cpassword = htmlspecialchars($_POST["cpassword"]);
	if(!isValidUsername($username)) {
		echo "<p>Username should begin with a letter and should have a minimum length of 6 and should not contain more than 64 characters.</p>";
		echo "<p>Go to <a href='register.php'>Registration</a></p>";
		exit();
	}
	if(!isValidPassword($password)) {
		echo "<p>Password should contain at least one lowercase character, at least one uppercase character, at least one digit and should have a minimum length of eight.</p>";
		echo "<p>Go to <a href='register.php'>Registration</a></p>";
		exit();
	}
	if(strcmp($password,$cpassword) !=0)
	{
		echo "<p>Passwords do not match.</p>";
		echo "<p>Go to <a href='register.php'>Registration</a></p>";
		exit();
	}
	
	
	$dbconn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

	if (!$dbconn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$username_query_sql = "SELECT * FROM user WHERE name='$username'";
	$username_query_result = mysqli_query($dbconn, $username_query_sql);

	if (mysqli_num_rows($username_query_result) > 0) {
		echo "Error: The username entered is already taken<br>";
		echo "Go to <a href='register.php'>Register</a> or <a href='index.php'>Home</a>";
		exit();
	} else {
		//TODO: increase or decrease the cost as per requirements
		$hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
		$sql = "INSERT INTO user (name, hash) VALUES ('$username', '$hash')";

		if (mysqli_query($dbconn, $sql)) {
			echo "Welcome {$username}<br>";
			$user_id = mysqli_insert_id($dbconn);
			$_SESSION["user_id"] = $user_id;
			$_SESSION["user_name"] = $username;
			$_SESSION["logged_in"] = true;
			header("Location: dashboard.php");
		} else {
			echo "Error: " . $registration_sql . "<br>" . mysqli_error($dbconn);
		}
	}
	mysqli_free_result($username_query_result);
	mysqli_close($dbconn);
}

?>

<html lang="en">
<head>
<title>Registration</title>
</head>
<body>
<form action="" method="post">
<label for="username">Username</label><br>
<input type="text" name="username" id="username" required autofocus></input>
</br>
<label for="password">Password</label><br>
<input type="password" name="password" id="password" required></input>
</br>
<label for="cpassword">Confirm Password</label><br>
<input type="password" name="cpassword" id="cpassword" required></input>
</br>
<input type="submit" value="Register"></input>
</form>
<p>Go to <a href="index.php">Home</a></p>
</body>
</html>




  