<?php
include 'connection.php';
$connect = connectDB();
if ($connect) {

  if (isset($_POST["edit_tag"])) {
    $query = "UPDATE tag SET broken = !broken WHERE id =" . $_POST["edit_tag"] . ";";
    $result = $connect->query($query);
    header("location: ../tag.php?error=Violation registered.");
    return;
  }

  $query = "SELECT * FROM tag WHERE tag_number = \"" . $_POST["tag_number"] . "\";";
  if ($result = $connect->query($query)) {
    if ($result->num_rows == 0) {
      $query = "SELECT * FROM tag WHERE fk_serial_number = \"" . $_POST["serial_number"] . "\" ORDER BY fk_serial_number DESC LIMIT 1;";
      if ($result = $connect->query($query)) {
        if ($result->num_rows > 0) {
          $query = "UPDATE tag SET active=0, removed=1  WHERE fk_serial_number = \"" . $_POST["serial_number"] . "\";";
          $result = $connect->query($query);
        }
      }

      $query = "INSERT INTO tag(`tag_number`, `date_active`, `fk_serial_number`, `active`,`removed`) VALUE(\"" . $_POST["tag_number"] . "\",\"" . date('Y-m-d H:i:s') . "\",\"" . $_POST["serial_number"] . "\", 1,0)";
      if ($connect->query($query)) {
        header("location: ../tag.php");
      }
    } else {
      header("location: ../tag.php?error=Tag Already Exist");
    }
  } else {
    header("location: ../tag.php?error=" . $connect->error);
  }
} else {
  header("location: ../tag.php?error=" . $connect->error);
}
