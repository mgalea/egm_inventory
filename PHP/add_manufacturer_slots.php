<?php
  include 'connection.php';
  $connect = connectDB();
  if($connect){
    $manufacturerPHP = $_POST['manufacturerSlotPHP'];
    if($manufacturerPHP != ""){
      $manufacturers = explode(",", $manufacturerPHP);

      foreach ($manufacturers as &$value) {
        $query = "INSERT INTO manufacturer(`name_manufacturer`) VALUES(\"".$value."\")";
        $connect->query($query);
      }
      header("location: ../modify.php");
    }
    else{
      header("location: ../modify.php");
    }
  }
  else{
    header("location: ../modify.php?error=".$connect->error);
  }
?>
