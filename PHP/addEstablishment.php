<?php
include 'connection.php';
$connect = connectDB();

$types;

$lat = "";
$lng = "";


if (isset($_POST['coordinates'])) {
  $coordinates = explode(":", $_POST['coordinates']);
  $lat = $coordinates[0];
  $lng = $coordinates[1];
}

if ($_POST['typePHP'] != "") {
  $types = explode(",", $_POST['typePHP']);
}

if(count($types)==1){
  header("location: ../establishment.php?error=Choose at least one Establishment Type. Establishment has not been added.");
}

if ($connect) {

  $query = "SELECT count(*) as total FROM establishment WHERE official_permit_number=\"" . $_POST["permit_number"] . "\";";
  if ($result = $connect->query($query)) {
    $row = $result->fetch_assoc();
    if ($row["total"] > 0) {
      header("location: ../establishment.php?error=Establihment Permit Number (" . $_POST["permit_number"] . ") already exist. Establishment has not been added.");
    };
  }


  if (isset($_POST['coordinates'])) {
    $query = "INSERT INTO pstl_adr(`strt_nm`, `bldg_nm`, `twn_nm`, `ctry`, `latitude`, `longitude`, `pstl_code_number`)";
    $query = $query . " VALUES (\"" . $_POST['strt_nm'] . "\",\"" . $_POST['bldgNb'] . "\",\"" . $_POST['twnNm'] . "\",\"" . $_POST['ctry'] . "\"," . $lat . "," . $lng . ",\"" . $_POST['zip'] . "\");";
  } else {
    $query = "INSERT INTO pstl_adr(`strt_nm`, `bldg_nm`, `twn_nm`, `ctry`, `pstl_code_number`)";
    $query = $query . " VALUES (\"" . $_POST['strt_nm'] . "\",\"" . $_POST['bldgNb'] . "\",\"" . $_POST['twnNm'] . "\",\"" . $_POST['ctry'] . "\",\"" . $_POST['zip'] . "\");";
  }
  if ($result = $connect->query($query)) {
    $last_id = $connect->insert_id;
    $query = "INSERT INTO establishment(`official_permit_number`, `name`, `fk_id_pstl_adr`, `active`, `fk_license_number_operator`)";
    $query = $query . "VALUES(\"" . $_POST["permit_number"] . "\",\"" . $_POST["name"] . "\"," . $last_id . "," . $_POST["state"] . "," . $_POST["fk_license_number_operator"] . ");";
    if ($result = $connect->query($query)) {
      $last_id = $connect->insert_id;
      foreach ($types as $value) {
        if ($value > 0) {
          $query = "INSERT INTO establishment_type(`fk_permit_number`,`fk_establishment_type`)";
          $query = $query . "VALUES(" . $last_id . "," . $value . ");";
          $connect->query($query);
        }
      }
      header("location: ../establishment.php");
    } else {
      header("location: ../establishment.php?error=" . $connect->error);
    }
  } else {
    header("location: ../establishment.php?error=" . $connect->error);
  }
} else {
  header("location: ../establishment.php?error=" . $connect->error);
}
