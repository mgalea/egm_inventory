<?php

  include 'connection.php';
  $connect = connectDB();

  if($connect){
    $upload_dir = "../uploads/";
    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    $fk_slot_machines=$_POST["slot"];

    $id=0;

    $query ="SELECT image FROM photos WHERE fk_serial_number = \"".$fk_slot_machines."\" ORDER BY image;";

    if($result = $connect->query($query)){
      $id = 0;
      while($row = $result->fetch_assoc()){
          $name_e = $row['image'];
          $name = explode(".", $name_e);
          $serial = explode("_", $name[0]);
          if($id == $serial[1]){
              $id++;
          }
          else {
            break;
          }
      }
    }
    $actualpath = $fk_slot_machines."_".$id.".png";

    $file = $upload_dir . $actualpath;
    $success = file_put_contents($file, $data);
    if($success){
      $query = "INSERT INTO photos (image, fk_serial_number) VALUES (\"".$actualpath."\", \"".$fk_slot_machines."\")";
      $connect->query($query);
      header("Location: ../slot.php");
    } else {
      header("Location: ../slot.php?error=Server Error ".$connect->error);
    }
  }
  else{
    header("Location: ../slot.php?error=Server Error ".$connect->error);
  }

?>
