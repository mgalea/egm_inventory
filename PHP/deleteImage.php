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
      header("Location: ../slot_images.php?slot=".$_POST['slot']);
  }else{
    header("Location: ../slot_images.php?error=No Images Deleted.");
  }
}
else{
  header("Location: ../slot_images.php?error=Server Error ".$connect->error);
}
?>
