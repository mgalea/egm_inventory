<?php

include 'connection.php';
$connect = connectDB();

if($connect){
  if(!empty($_POST['images'])) {
      foreach($_POST['images'] as $image) {
        $query = "SELECT * FROM photos WHERE id=".$image.";";
        if($result = $connect->query($query)){
          $row = $result->fetch_assoc();
          if(unlink("../uploads/".$row["image"])){
            $query = "DELETE FROM photos WHERE id=".$image.";";
            $connect->query($query);
          }
        }
      }
      header("Location: ../slot.php");
  }
}
else{
  header("Location: ../slot.php?error=Server Error ".$connect->error);
}
?>
