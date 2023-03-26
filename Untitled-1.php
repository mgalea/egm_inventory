if ($connect && $serial_number != "") {


    $query = "SELECT * FROM slot_machines, manufacturer, type_slot_machines, slot_model WHERE serial_number = \"" . $serial_number . "\";";

    if ($result = $connect->query($query)) {
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $serial_number_motherboard = $row["fk_serial_number_motherboard"];
        $license_number_operator = $row["fk_license_number"];
        $manufacturer = $row["name_manufacturer"];
        $date_manufacturing = $row["date_manufacturing"];
        $id_model = $row["id_model"];
        $model = $row["name_model"];
        $type = $row["name_type"];
        $id_manufacturer = $row["fk_id_manufacturer"];
        $id_type = $row["fk_slot_type"];
        $state = $row["commission"];
        $date_commission = $row["date_commission"];
        $date_decommission = $row["date_decommission"];
        $type_player = $row["multi_game"];
        $multiterminal = $row["multi_terminal"];
        $regulator_number = $row["reg_number"];
        $operator_number = $row["operator_number"];
        $est_location = $row["est_location"];
        $is_original = $row["is_original"];

        $query = "SELECT fk_establishment, name FROM slot_machines_establishment, establishment WHERE fk_establishment = permit_number AND fk_slot_machines = $serial_number;";
        if ($result = $connect->query($query)) {
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $license_number_establishment = $row["fk_establishment"];
            $establishment = $row["name"];
          }
        }

        $query = "SELECT company_name FROM operator WHERE license_number = " . $license_number_operator . "";
        if ($result = $connect->query($query)) {
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $operator_name = $row["company_name"];
          }
        }
      }
    } else {
      echo $connect->error;
    }
  }