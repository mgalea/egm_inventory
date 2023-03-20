<?php
  include 'connection.php';
  $connect = connectDB();

  $error="";

  $total = count($_FILES['fileToUpload']['name']);

  $fk_slot_machines=$_POST["slot"];

  if($connect){
    for($i=0;$i<$total;$i++){

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
      else{
        $error = $error . " ".$connect->error;
      }

      $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"][$i]),PATHINFO_EXTENSION));


      $actualpath = $fk_slot_machines."_".$id.".".$imageFileType;

      $target_file = "../uploads/".$actualpath;

      $uploadOk = 1;

      if ($_FILES["fileToUpload"]["size"][$i] > 5000000) {
        $error = $error . " Sorry, your file is too large.";
        $uploadOk = 0;
      }

      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $error = $error . " Sorry, only PNG, JPEG, JPG and GIF files are allowed.";
        $uploadOk = 0;
      }

      if ($uploadOk == 0) {
        $error = $error . " Sorry, your file was not uploaded.";
      }
      else{
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
            $query = "INSERT INTO photos (image, fk_serial_number) VALUES (\"".$actualpath."\", \"".$fk_slot_machines."\")";
            if(!$connect->query($query)){
              $error = $error . " Server Error ".$connect->error;
            }
        }
        else{
          $error = $error . " Server Error ".$connect->error;
        }
      }
    }
  }
  else{
    header("location: ../slot.php?error=".$connect->error);
  }

  if($connect->error=="" && $error == ""){
    header("location: ../slot.php");
  }
  else {
    header("location: ../slot.php?error=".$connect->error);
  }

?>
