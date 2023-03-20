<?php
  include 'connection.php';
  $connect = connectDB();

  if($connect){
    $brandPHP = $_POST['brandOperatorPHP'];
    if($brandPHP != ""){
      $brands = explode(",", $brandPHP);

      foreach ($brands as &$value) {
        $query = "INSERT INTO brand(`name`) VALUES(\"".$value."\")";
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
