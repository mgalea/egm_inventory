<?php
  include 'connection.php';
  $connect = connectDB();

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
  $is_original=0;
  $serial_number_motherboard = $_POST['serial_number_motherboard'];
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

  echo "fk_license_number_operator:".$fk_license_number."</br>";
  echo "license_number:".$license_number."</br>";
  echo "serial_number:".$serial_number."</br>";
  echo "regulator_number:".$regulator_number."</br>";
  echo "operator_number:".$operator_number."</br>";
  echo "date_manufacturing:".$date_manufacturing."</br>";
  echo "model:".$model."</br>";
  echo "type:".$type."</br>";
  echo "number_game:".$number_game."</br>";
  echo "multiterminal:".$multiterminal."</br>";
  echo "state:".$state."</br>";
  echo "establishment_location:".$establishment_location."</br>";
  echo "date_commission:".$date_commission."</br>";
  echo "date_decommission:".$date_decommission."</br>";
  echo "is_original:".$is_original."</br>";
  echo "serial_number_motherboard:".$serial_number_motherboard."</br>";
  echo "manufacturer_motherboard:".$manufacturer_motherboard."</br>";
  echo "model_motherboard:".$model_motherboard."</br>";
  echo "power_jumper_number:".$power_jumper_number."</br>";
  echo "power_jumper_type:".$power_jumper_type."</br>";
  echo "com_jumper_number:".$com_jumper_number."</br>";
  echo "com_jumper_type:".$com_jumper_type."</br>";



?>
