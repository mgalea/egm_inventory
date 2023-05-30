<?php
  include 'connection.php';
  $connect = connectDB();



  $query= "SELECT * FROM slot_machines WHERE serial_number=\"".$_POST['serial_number']."\";";

  if($result=$connect->query($query)){
    if($result->num_rows>0){
      header("location: ../slot.php?error=Slot serial number already used.");
      exit;
    }
  }

  $query= "SELECT * FROM motherboard WHERE serial_number_motherboard=\"".$_POST['serial_number_motherboard']."\";";

  if($result=$connect->query($query)){
    if($result->num_rows>0){
      header("location: ../slot.php?error=Motherboard serial number already used.");
      exit;
    }
  }

  $fk_license_number = $_POST['fk_license_number_operator'];

  $license_number = "";
  if(isset($_POST['license_establishment']) && $_POST['license_establishment']!=""){
    $license_number = $_POST['license_establishment'];
  }
  $serial_number = $_POST['serial_number'];
  $regulator_number=$_POST['regulator_number'];
  $operator_number=$_POST['operator_number'];
  $date_manufacturing = $_POST['date_manufacturing'];
  $model = $_POST['model'];
  $type = $_POST['type'];
  $number_game = $_POST['number_game'];
  $multiterminal = "0";

  if(isset($_POST['multiterminal'])){
    if($_POST['multiterminal']!="1"){
      $multiterminal="0";
    }
    else{
      $multiterminal=1;
    }
  }

  $state = $_POST['state'];
  $establishment_location=$_POST['est_location'];
  $date_commission = $_POST['date_commission'];
  $date_decommission="";
  if($state==0){
    $date_decommission = $_POST['date_decommission'];
  }

  $serial_number_motherboard = $_POST['serial_number_motherboard'];

  $is_original=0;

  if(isset($_POST['is_original'])){
    if($_POST['is_original']=="1"){
      $is_original=1;
    }
    else{
      $is_original=0;
    }
  }
  else{
    $is_original=0;
  }
  $manufacturer_motherboard = $_POST['manufacturer_motherboard'];
  $model_motherboard = $_POST['model_motherboard'];
  $power_jumper_number = 0;
  $power_jumper_type = "";
  $com_jumper_number = 0;
  $com_jumper_type = "";

  if(isset($_POST['power_jumper_number']) && $_POST['power_jumper_number']!=""){
    $power_jumper_number = $_POST['power_jumper_number'];
  }
  if(isset($_POST['power_jumper_type']) && $_POST['power_jumper_type']!=""){
    $power_jumper_type = $_POST['power_jumper_type'];
  }
  if(isset($_POST['com_jumper_number']) && $_POST['com_jumper_number']!=""){
    $com_jumper_number = $_POST['com_jumper_number'];
  }
  if(isset($_POST['com_jumper_type']) && $_POST['com_jumper_type']!=""){
    $com_jumper_type = $_POST['com_jumper_type'];
  }

  $broken="0";

  if($multiterminal!="1"){
    $multiterminal="0";
  }

  if($connect){
    $query="INSERT INTO motherboard(`serial_number_motherboard`,`power_jumper_number`, `power_jumper_type`, `com_jumper_number`, `com_jumper_type`, `fk_manufacturer`, `model_motherboard`) ";
 
    $query = $query . "VALUES(\"".$serial_number_motherboard."\",\"".$power_jumper_number."\",\"" .$power_jumper_type."\",\" ".$com_jumper_number."\", \"".$com_jumper_type."\", ".$manufacturer_motherboard.", \"".$model_motherboard."\")";
    echo $query;
    if($connect->query($query)){

      $query="INSERT INTO slot_machines(`serial_number`, `date_manufacturing`, `fk_license_number`, `fk_model`, `fk_slot_type`, `date_commission`, `est_location`, `commission`, `date_decommission`, `multi_terminal`, `multi_game`, `reg_number`, `operator_number`, `is_original`, `fk_serial_number_motherboard`)";
      if($state==0){
        $query = $query." VALUES (\"".$serial_number."\",\"".$date_manufacturing."\", ".$fk_license_number.", ".$model.", ".$type.", \"".$date_commission."\", \"". $establishment_location."\", ".$state.", \"".$date_decommission."\", ". $multiterminal.", ".$number_game.", \"".$regulator_number."\", \"".$operator_number."\", ".$is_original.", \"".$serial_number_motherboard."\");";
      }
      else{
        $query = $query." VALUES (\"".$serial_number."\",\"".$date_manufacturing."\", ".$fk_license_number.", ".$model.", ".$type.", \"".$date_commission."\", \"". $establishment_location."\", ".$state.", null, ". $multiterminal.", ".$number_game.", \"".$regulator_number."\", \"".$operator_number."\", ".$is_original.", \"".$serial_number_motherboard."\");";
      }

      if($connect->query($query)){
        if($license_number!=""){
          $query = "INSERT INTO slot_machines_establishment(`fk_establishment`,`fk_slot_machines`) VALUES(".$license_number.", \"".$serial_number."\");";
          if($connect->query($query)){
            header("location: ../slot.php?error=Slot machine with serial number ".$serial_number." added successfully.");
          }
          else{
            header("location: ../slot.php?error=1 ".$connect->error);
          }
        }

      }
      else{
        header("location: ../slot.php?error=2 ".$connect->error);
      }
    }
    else{
      header("location: ../slot.php?error=3 ".$connect->error);
    }
  }
  else{
    header("location: ../slot.php?error=4 ".$connect->error);
  }
