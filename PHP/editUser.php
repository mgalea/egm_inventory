<?php
  include 'connection.php';
  $connect = connectDB();

  $id_user = $_POST['id_user'];

  if($connect){
    $active = "";
    if((isset($_POST["active"]) && $_POST["active"]=="1") || $_POST["type-user"] == "1"){
      $active= "1";
    }
    else{
      $active= "0";
    }
    $query= "UPDATE users SET user_type=".$_POST["type-user"].", username=\"".$_POST["username"]."\", email=\"".$_POST["email"]."\", telephone=\"".$_POST["telephone"]."\", organization=\"".$_POST["organization"]."\", active=\"".$active."\" WHERE id=".$id_user.";";
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
