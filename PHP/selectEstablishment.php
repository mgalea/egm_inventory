<?php

  include 'connection.php';
  $connect = connectDB();
  if($connect){
    $query="SELECT * FROM establishment WHERE fk_license_number_operator = ".$_POST["operator"].";";
    if($result = $connect->query($query)){
      while($row = $result->fetch_assoc()){
        echo $row["permit_number"].":".$row["name"].":";
      }
    }
  }
  
?>
