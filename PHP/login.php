<?php

include 'connection.php';
$connect = connectDB();

session_start();

$user = $_POST['username'];
$pasw = $_POST['password'];

$str_salt_query= "SELECT user_pasw from users WHERE BINARY username='$user'";
$result = $connect->query($str_salt_query);


if($result->num_rows == 1)
{
	$salt;
	while($row = $result->fetch_assoc())
	{
		$salt=explode(":",$row['user_pasw']);
	}
	$salt_clear=$salt[0];

	$password_encrypted=hash("sha512",$salt_clear.$pasw);
	$pass_f=$salt_clear.":".$password_encrypted;

	$strSQL= "SELECT * FROM users WHERE BINARY username='$user' AND BINARY user_pasw='$pass_f'";


	$result = $connect->query($strSQL);
	if($result->num_rows == 1){
		$row = $result->fetch_assoc();
		if($row['active']=="1"){
			$_SESSION['user'] = $user;
			$_SESSION['user_type'] = $row['user_type'];
			header("Location: ../index.php");
		}
		else{
			header("Location: ../login.php?error=Username Unactive");
		}
	}
  else{
    header("Location: ../login.php?error=Error password!");
    //header("Location: index.php");
  }
}
else {
  header("Location: ../login.php?error=Username error!");
	//header("Location: index.php");
}





?>
