<?php
include 'connection.php';
$connect = connectDB();

$license_number = $_POST['license_number'];
$lat = "";
$lng = "";

$brandString = $_POST['brandPHP'];
$brands = explode(",", $brandString);

if (isset($_POST['coordinates']) && $_POST['coordinates'] != "unchecked") {
  $coordinates = explode(":", $_POST['coordinates']);
  $lat = $coordinates[0];
  $lng = $coordinates[1];
}

if ($connect) {
  $query = "UPDATE operator SET company_name=\"" . $_POST["company_name"] . "\", company_telephone=\"" . $_POST["company_telephone"] . "\", company_email=\"" . $_POST["company_email"] . "\", company_website=\"" . $_POST["company_website"] . "\", jurisdiction=\"" . $_POST["jurisdiction"] . "\" WHERE license_number=" . $license_number . ";";
  if ($result = $connect->query($query)) {
    $query = "SELECT fk_id_pstl_adr FROM operator WHERE license_number=" . $license_number . ";";
    if ($result = $connect->query($query)) {
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fk_id_pstl_adr = $row["fk_id_pstl_adr"];
        $query = "";
        if (isset($_POST['coordinates']) && $_POST['coordinates'] != "unchecked") {
          $query = "UPDATE pstl_adr SET strt_nm=\"" . $_POST["strt_nm"] . "\", bldg_nm=\"" . $_POST["bldgNb"] . "\", twn_nm=\"" . $_POST["twnNm"] . "\", ctry=\"" . $_POST["ctry"] . "\", pstl_code_number=\"" . $_POST["zip"] . "\", latitude=" . $lat . ", longitude=" . $lng . "  WHERE id_pstl_adr=" . $fk_id_pstl_adr . ";";
        } else {
          $query = "UPDATE pstl_adr SET strt_nm=\"" . $_POST["strt_nm"] . "\", bldg_nm=\"" . $_POST["bldgNb"] . "\", twn_nm=\"" . $_POST["twnNm"] . "\", ctry=\"" . $_POST["ctry"] . "\", pstl_code_number=\"" . $_POST["zip"] . "\", latitude=null, longitude=null WHERE id_pstl_adr=" . $fk_id_pstl_adr . ";";
        }

        if ($connect->query($query)) {
          $query = "DELETE FROM brand_operator WHERE fk_operator = " . $license_number . ";";
          $connect->query($query);
          if (count($brands) > 1) {
           
            for ($i = 1; $i < count($brands); $i++) {
              $query = "INSERT INTO brand_operator(`fk_operator`,`fk_brand`) VALUES(".$license_number.",".$brands[$i].")";
              $connect->query($query);
            }             
            
          }
          header("location: ../operator.php");

        } else {
          header("location: ../operator.php?error=" . $connect->error);
        }
      } else {
        header("location: ../operator.php?error=" . $connect->error);
      }
    } else {
      header("location: ../operator.php?error=" . $connect->error);
    }
  } else {
    header("location: ../operator.php?error=" . $connect->error);
  }
} else {
  header("location: ../operator.php?error=" . $connect->error);
}
