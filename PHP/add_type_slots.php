<?php
  include 'connection.php';
  $connect = connectDB();

  if($connect){
    $typePHP = $_POST['typeSlotsPHP'];
    if($typePHP!=""){
      $types = explode(",", $typePHP);

      foreach ($types as &$value) {
        $query = "INSERT INTO type_slot_machines(`name_type`) VALUES(\"".$value."\")";
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
