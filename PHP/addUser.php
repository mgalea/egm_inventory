<?php
  include 'connection.php';
  $connect = connectDB();

  if($connect){
    $active = "";
    if((isset($_POST["active"]) && isset($_POST["active"])=="1") || $_POST["type-user"] == "1"){
      $active= "1";
    }
    else{
      $active= "0";
    }
    $pw=$_POST["password"];
    $salt = uniqid(mt_rand(), false);
    $pw_encrypted=hash("sha512", $salt.$pw);
    $password=$salt.":".$pw_encrypted;
    $query= "INSERT INTO users(`user_pasw`, `user_type`, `username`, `email`, `telephone`, `organization`, `active`)";
    $query=$query." VALUES(\"".$password."\",".$_POST["type-user"].",\"".$_POST["username"]."\",\"".$_POST["email"]."\",\"".$_POST["telephone"]."\",\"".$_POST["organization"]."\",".$active.")";
    if($connect->query($query)){
      header("location: ../modify.php");
    }
    else{
      header("location: ../modify.php?error=".$connect->error);
    }
  }
  else{
    header("location: ../modify.php?error=".$connect->error);
  }
?>
