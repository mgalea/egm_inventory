<?php

  include 'connection.php';
  $connect = connectDB();
  if($connect){
    $query="SELECT * FROM slot_model WHERE fk_id_manufacturer = ".$_POST["manufacturer"].";";
    if($result = $connect->query($query)){
      while($row = $result->fetch_assoc()){
        echo $row["id_model"].":".$row["name_model"].":";
      }
    }
  }

?>
