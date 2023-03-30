<?php
  include 'connection.php';
  $connect = connectDB();

  $serial_number = $_POST['serial_number'];

  $license_number = "";
  if(isset($_POST['license_establishment']) && $_POST['license_establishment']!=""){
    $license_number = $_POST['license_establishment'];
  }

  $multiterminal = "0";
  if(isset($_POST['multiterminal'])){
    if($_POST['multiterminal']!="1"){
      $multiterminal="0";
    }
    else{
      $multiterminal="1";
    }
  }

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

  if($connect){

    $query = "SELECT * FROM motherboard WHERE serial_number_motherboard = \"".$_POST["serial_number_motherboard"]."\";";
    if($result = $connect->query($query)){
      $is_original = 0;
      if(isset($_POST["is_original"]) && $_POST["is_original"]=="1"){
        $is_original = 1;
      }
      else{
        $is_original = 0;
      }
      if($result->num_rows > 0){
        $query= "UPDATE motherboard SET com_jumper_number = \"".$com_jumper_number."\", com_jumper_type = \"" . $com_jumper_type . "\", power_jumper_number = \"".$power_jumper_number."\",power_jumper_type = \"".$power_jumper_type."\", model_motherboard = \"".$_POST["model_motherboard"]."\" WHERE serial_number_motherboard = \"" .$_POST["serial_number_motherboard"]. "\";";
        echo $query;
        if(!$connect->query($query)){
          header("location: ../slot.php?error=11".$connect->error);
        }
      }
      else{
        $query= "INSERT INTO motherboard(`serial_number_motherboard`, `fk_manufacturer` ,`com_jumper_number`, `com_jumper_type`, `power_jumper_number`, `power_jumper_type`, `model_motherboard`) VALUES(\"".$_POST["serial_number_motherboard"]."\",".$_POST["manufacturer_motherboard"].",".$com_jumper_number.",\"".$com_jumper_type."\",".$power_jumper_number.",\"".$power_jumper_type."\", \"".$_POST["model_motherboard"]."\");";
        if(!$connect->query($query)){
          header("location: ../slot.php?error=12".$connect->error);
        }
      }
      $query= "UPDATE slot_machines SET date_manufacturing=\"".$_POST["date_manufacturing"]."\", fk_model=\"".$_POST["model"]."\", fk_slot_type=".$_POST["type"].", fk_serial_number_motherboard = \"".$_POST["serial_number_motherboard"]."\", is_original = ".$is_original.", ";
      if($_POST["state"]==0){
        $query = $query . " est_location = \"".$_POST["est_location"]."\", commission = ".$_POST["state"].", date_commission = \"".$_POST["date_commission"]."\" , date_decommission = \"".$_POST["date_decommission"]."\", multi_game = ".$_POST["number_game"].", multi_terminal = ".$multiterminal.", reg_number = ".$_POST["regulator_number"].", operator_number = ".$_POST["operator_number"]." WHERE serial_number=\"".$serial_number."\";";
      }
      else{
        $query = $query . " est_location = \"".$_POST["est_location"]."\", commission = ".$_POST["state"].", date_commission = \"".$_POST["date_commission"]."\" , date_decommission = null , multi_game = ".$_POST["number_game"].", multi_terminal = ".$multiterminal.", reg_number = ".$_POST["regulator_number"].", operator_number = ".$_POST["operator_number"]." WHERE serial_number=\"".$serial_number."\";";
      }
      if($result = $connect->query($query)){
        $query= "SELECT fk_establishment FROM slot_machines_establishment WHERE fk_slot_machines = \"".$serial_number."\";";
        if($result = $connect->query($query)){
          if($result->num_rows > 0){
            if($license_number==""){
              $query = "DELETE FROM slot_machines_establishment WHERE fk_slot_machines = \"".$serial_number."\";";
              $connect->query($query);
            }
            else {
              $query = "UPDATE slot_machines_establishment SET fk_establishment = ".$license_number." WHERE fk_slot_machines = \"".$serial_number."\";";
              $connect->query($query);
            }
          }
          else {
            $query = "INSERT INTO slot_machines_establishment(`fk_establishment`,`fk_slot_machines`) VALUES(".$license_number.", \"".$serial_number."\");";
            $connect->query($query);
          }
        }
        else{
          header("location: ../operator.php?error=".$connect->error);
        }
      }
      else{
        header("location: ../operator.php?error=".$connect->error);
      }
    }
    else{
      header("location: ../operator.php?error=".$connect->error);
    }
  }
  if($connect->error==""){
    header("location: ../slot.php");
  }
  else {
    header("location: ../slot.php?error=".$connect->error);
  }
?>
