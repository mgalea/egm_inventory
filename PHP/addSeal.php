<?php
  include 'connection.php';
  $connect = connectDB();
  if($connect){
    $query = "SELECT * FROM seal WHERE seal_number = \"".$_POST["seal_number"]."\";";
    if($result = $connect->query($query)){
      if($result->num_rows == 0){
        $query="UPDATE seal SET broken = 1 WHERE fk_serial_number = \"".$_POST["slot"]."\";";
        if($connect->query($query)){
          $query="INSERT INTO seal(`seal_number`, `date_seal`, `fk_serial_number`, `broken`) VALUE(\"".$_POST["seal_number"]."\",\"".$_POST["date_seal"]."\",\"".$_POST["slot"]."\", 0)";
          if(!$connect->query($query)){
            echo $connect->error;
          }
        }
        else{
          echo $connect->error;
        }
      }
      else{
        echo "Server Error!";
      }
    }
    else{
      echo $connect->error;
    }
  }
  else{
    echo $connect->error;
  }
?>
