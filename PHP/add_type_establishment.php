<?php
  include 'connection.php';
  $connect = connectDB();
  if($connect){
    $typePHP = $_POST['typeEstablishmentPHP'];
    if($typePHP!=""){
      $types = explode(",", $typePHP);
      foreach ($types as &$value) {
        $query = "INSERT INTO type(`namet`) VALUES(\"".$value."\")";
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
