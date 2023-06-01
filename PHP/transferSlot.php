<?php
include 'connection.php';
$connect = connectDB();


if ($connect) {
  $query = "UPDATE slot_machines_establishment SET fk_establishment=" . $_POST['to_establishment'] . " WHERE fk_slot_machines =\"" . $_POST['serial_number'] . "\";";

  if ($connect->query($query)) {
    header("location: ../slot.php?error=Slot machine with serial number " . $serial_number . " transferred successfully.");
  } else {
    header("location: ../slot.php?error=1 " . $connect->error);
  }
}
