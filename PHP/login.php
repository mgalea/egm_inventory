<?php

include 'connection.php';
$connect = connectDB();





if (empty($_POST['username']) ){
	header("Location: ../login.php?error=Username cannot be empty.");
	exit;
}

if (empty(ltrim($_POST['username']))){
	header("Location: ../login.php?error=Only ghosts can use empty spaces.");
	exit;
}


if (empty($_POST['password']) ){
	header("Location: ../login.php?error=Password cannot be empty.");
	exit;
}

if (empty(ltrim($_POST['password'])) ){
	header("Location: ../login.php?error=That's a strange password!");
	exit;
}

$user = $_POST['username'];
$pasw = $_POST['password'];

$str_salt_query = "SELECT user_pasw from users WHERE BINARY username='$user'";
$result = $connect->query($str_salt_query);


if ($result->num_rows == 1) {
	$salt;
	while ($row = $result->fetch_assoc()) {
		$salt = explode(":", $row['user_pasw']);
	}
	$salt_clear = $salt[0];

	$password_encrypted = hash("sha512", $salt_clear . $pasw);
	$pass_f = $salt_clear . ":" . $password_encrypted;

	$strSQL = "SELECT * FROM users WHERE BINARY username='$user' AND BINARY user_pasw='$pass_f'";

	$result = $connect->query($strSQL);
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if ($row['active'] == "1") {
			$_SESSION['user'] = $user;
			$_SESSION['user_type'] = $row['user_type'];
			$_SESSION['user_id'] = $row['id'];
			
			header("Location: ../index.php");
		} else {
			header("Location: ../login.php?error=Username Inactive.");
		}
	} else {
		header("Location: ../login.php?error=Error password!");
	
	}
} else {
	header("Location: ../login.php?error=Username error.");
	
}
