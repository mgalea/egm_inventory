<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://kit.fontawesome.com/8be26e49e1.js" crossorigin="anonymous"></script>
  <link rel="icon" href="favicon/favicon.png">

  <script src="https://www.w3schools.com/lib/w3.js"></script>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript">
    function searchInSlots() {
      // Declare variables
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      <?php if (!isset($_POST['establishment']) && !isset($_POST['operator'])) { ?>
        for (i = 0; i < tr.length; i++) {
          td1 = tr[i].getElementsByTagName("td")[0];
          td2 = tr[i].getElementsByTagName("td")[1];
          td3 = tr[i].getElementsByTagName("td")[2];
          td4 = tr[i].getElementsByTagName("td")[3];
          td5 = tr[i].getElementsByTagName("td")[4];
          td6 = tr[i].getElementsByTagName("td")[5];
          if (td1) {
            if ((td1.innerHTML.toUpperCase().indexOf(filter) > -1) || (td2.innerHTML.toUpperCase().indexOf(filter) > -1) || (td3.innerHTML.toUpperCase().indexOf(filter) > -1) || (td4.innerHTML.toUpperCase().indexOf(filter) > -1) || (td5.innerHTML.toUpperCase().indexOf(filter) > -1) || (td6.innerHTML.toUpperCase().indexOf(filter) > -1)) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      <?php } else { ?>
        for (i = 0; i < tr.length; i++) {
          td1 = tr[i].getElementsByTagName("td")[0];
          td2 = tr[i].getElementsByTagName("td")[1];
          td3 = tr[i].getElementsByTagName("td")[2];
          td4 = tr[i].getElementsByTagName("td")[3];
          td5 = tr[i].getElementsByTagName("td")[4];
          if (td1) {
            if ((td1.innerHTML.toUpperCase().indexOf(filter) > -1) || (td2.innerHTML.toUpperCase().indexOf(filter) > -1) || (td3.innerHTML.toUpperCase().indexOf(filter) > -1) || (td4.innerHTML.toUpperCase().indexOf(filter) > -1) || (td5.innerHTML.toUpperCase().indexOf(filter) > -1)) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      <?php } ?>
    }
  </script>

</head>

<body>
  <div class="header">
    <?php
    include 'header.php';
    ?>
  </div>
  <main class="flex-shrink-0">
    <div class="container-fluid">
      <div class="row my-3">
        <div class="col-8">
          <h1>Slots</h1>
          <?php
          if (isset($_POST['establishment'])) {
            $query = "SELECT * from establishment where  permit_number = " . $_POST['establishment'] . ";";
            $result = $connect->query($query);
            $row = $result->fetch_assoc();
            echo "<h4><b>Establishment: </b>" . $row['name'] . "</h4>";
            $query = "SELECT * from operator where  license_number = " . $row['fk_license_number_operator'] . " LIMIT 1;";
            $result = $connect->query($query);
            $row = $result->fetch_assoc();
            echo "<h4><b>Operator: </b>" . $row['company_name'] . "</h4>";
          }
          ?>
        </div>

        <?php if (isset($_POST['operator'])) {
          $query = "SELECT company_name from operator where  official_license_number LIKE \"" . $_POST['operator'] . "\" LIMIT 1;";
          $result = $connect->query($query);
          $row = $result->fetch_assoc();
        ?>
          <div class="row">
            <div class="col-8">
              <p class="fs-2"><b>Operator: <?php echo $row['company_name'] ?></b>

                <button class="ms-3 btn btn-lg btn-primary" onclick="showEstablishment()">Show Establishments</button>
              </p>
            </div>

          </div>
        <?php } ?>

      </div>
      <div class="row my-3">
        <div class="col-10">
          <input type="text" id="myInput" onkeyup="searchInSlots()" placeholder="Search ...">
        </div>
        <div class="col-2">
          <button class="btn btn-lg btn-success float-end" onclick="document.getElementById('id_add_slot').style.display='block'">Add Slot</button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <table id="myTable" class="w3-table-all w3-small w3-responsive">
            <tr>
              <?php if (!isset($_POST['establishment']) && !isset($_POST['operator'])) { ?>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Operator <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">Operator Number <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Manufacturer <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(4)')" style="cursor:pointer">Serial Number <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(5)')" style="cursor:pointer">Type <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(6)')" style="cursor:pointer">Model <i class="fa fa-sort" style="font-size:13px;"></i></th>
              <?php } else { ?>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Operator Number <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">Manufacturer <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Serial Number <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(4)')" style="cursor:pointer">Type <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(5)')" style="cursor:pointer">Model <i class="fa fa-sort" style="font-size:13px;"></i></th>
              <?php } ?>
              <th class="w3-dark-grey w3-hover-black">Actions</th>
            </tr>
            <?php
            if ($connect) {
              if (isset($_POST['establishment'])) {
                $query = "SELECT * from slot_machines, slot_model, type_slot_machines, slot_machines_establishment, manufacturer where fk_model = id_model AND fk_id_manufacturer = id_manufacturer AND fk_slot_type = id_type_slot_machines AND fk_slot_machines = serial_number AND fk_establishment = " . $_POST['establishment'] . ";";
                if ($result = $connect->query($query)) {
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr class=\"item\"><td>" . $row["operator_number"] . "</td><td>" . $row["name_manufacturer"] . "</td><td>" . $row["serial_number"] . "</td><td>" . $row["name_type"] . "</td><td>" . $row["name_model"] . "</td><td><i class='fa-light fa-2x fa-tag'></i></td><td onclick=\"edit_slot('" . $row["serial_number"] . "')\"><img class=\"icon\" src=\"images/edit.png\" alt=\"Edit\"></td><td onclick=\"info_slot('" . $row["serial_number"] . "')\"><img class=\"icon\" src=\"images/info.png\" alt=\"Info\"></td></tr>";
                    }
                  }
                }
              } else if (isset($_POST['operator'])) {
                $query = "SELECT * from slot_machines, slot_model, type_slot_machines, manufacturer, operator where fk_model = id_model AND fk_id_manufacturer = id_manufacturer AND fk_slot_type = id_type_slot_machines AND fk_license_number = license_number AND official_license_number = \"" . $_POST['operator'] . "\";";
                if ($result = $connect->query($query)) {
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr class=\"item\"><td>" . $row["operator_number"] . "</td><td>" . $row["name_manufacturer"] . "</td><td>" . $row["serial_number"] . "</td><td>" . $row["name_type"] . "</td><td>" . $row["name_model"] . "</td><td><i class=\"fa-light fa-2x fa-tag seal\"></i></td><td onclick=\"edit_slot('" . $row["serial_number"] . "')\"><img class=\"icon\" src=\"images/edit.png\" alt=\"Edit\"></td><td onclick=\"info_slot('" . $row["serial_number"] . "')\"><img class=\"icon\" src=\"images/info.png\" alt=\"Info\"></td></tr>";
                    }
                  }
                }
              } else {
                $query = "SELECT * from slot_machines, slot_model, type_slot_machines, manufacturer, operator where fk_model = id_model AND fk_id_manufacturer = id_manufacturer AND fk_slot_type = id_type_slot_machines AND fk_license_number = license_number LIMIT 100;";
                if ($result = $connect->query($query)) {
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr class=\"item\"><td>" . $row["company_name"] . "</td><td>" . $row["operator_number"] . "</td><td>" . $row["name_manufacturer"] . "</td><td>" . $row["serial_number"] . "</td><td>" . $row["name_type"] . "</td><td>" . $row["name_model"] . "</td><td><i class='fa-duotone fa-2x fa-image p-2' onclick=\"show_image('" . $row["serial_number"] . "')\"></i><i class='fa-duotone fa-2x fa-tag p-2' onclick=\"show_tag('" . $row["serial_number"] . "')\"></i><i class='fa-duotone fa-2x fa-square-pen p-2' onclick=\"edit_slot('" . $row["serial_number"] . "')\"></i> <i class='fa-duotone fa-2x  fa-square-info p-2' onclick=\"info_slot('" . $row["serial_number"] . "')\"></i></td></tr>";
                    }
                  }
                }
              }
            }
            ?>
          </table>
        </div>
      </div>
  </main>

  <div class="footer mt-auto">
    <?php
    include 'footer.php';
    ?>
  </div>

  <div class="div-body">
    <style media="screen">
      <?php
      if (isset($_POST['slot'])) {
        echo "
          .modal-div {
            display: block;
          }";
      };
      if (isset($_POST['slot_info'])) {
        echo "
          .modal-div-info {
            display: block;
          }";
      };
      ?>
    </style>
    <?php
    $serial_number_motherboard = "";
    $id_manufacturer_motherboard = "";
    $regulator_number = "";
    $operator_number = "";
    $type_player = "0";
    $multiterminal = "";
    $serial_number = "";
    $id_manufacturer = "";
    $id_type = "";
    $license_number_operator = "";
    $operator_name = "";
    $license_number_establishment = "";
    $establishment = "";
    $manufacturer = "";
    $date_manufacturing = "";
    $id_model = "";
    $model = "";
    $type = "";
    $com_jumper_number = "";
    $com_jumper_type = "";
    $power_jumper_number = "";
    $power_jumper_type = "";
    $state = "1";
    $date_commission = "";
    $date_decommission = "";
    $operator_slot_edit = "";
    $est_location = "";
    $is_original = "";
    $model_motherboard = "";
    $tag_namber = "";

    if (isset($_POST['establishment'])) {
      $query = "SELECT * FROM establishment WHERE official_permit_number = \"" . $_POST['establishment'] . "\";";
      if ($result = $connect->query($query)) {
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $official_permit_license = $row["permit_number"];
        }
      }
    }

    if (isset($_POST['slot'])) {
      $serial_number = $_POST['slot'];
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
    if (isset($_POST['slot_info'])) {
      $serial_number = $_POST['slot_info'];
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

            $query = "SELECT * from tag where fk_serial_number = $serial_number;";
            if ($result = $connect->query($query)) {
              if ($result->num_rows > 0) {
                $tag_number = $row["tag_number"];
              } else {
                $tag_number = "<span class='badge bg-danger'>NO TAG <span>";
              }
            }

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
    }


    ?>
  </div>

  <div id="id_info_slot" class="modal-div-info">
    <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
    <div class="modal-div-content">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <h1 style="margin-top: 20px; float : center;"><b>EGM Details</b></h1>
            <table class="w3-table-all">
              <tr>
                <td><b> Serial Number:</b></td>
                <td> <?php echo $serial_number; ?></td>
              </tr>
              <tr>
                <td><b> Tag Number:</b></td>
                <td> <?php echo $tag_number; ?></td>
              </tr>

              <tr>
                <td><b>Regulator Number:</b></td>
                <td> <?php echo $regulator_number; ?></td>
              </tr>
              <tr>
                <td><b>Operator Number:</b></td>
                <td> <?php echo $operator_number; ?></td>
              </tr>
              <tr>
                <td><b>Operator:</b> </td>
                <td><?php echo $operator_name; ?></td>
              </tr>
              <tr>
                <td><b>Establishment:</b></td>
                <td> <?php if ($establishment != "") echo $establishment;
                      else echo  " ~ "; ?></td>
              </tr>
              <tr>
                <td><b>Manufacturer:</b> </td>
                <td> <?php echo $manufacturer; ?></td>
              </tr>
              <tr>
                <td><b>Date of manufacturing:</b> </td>
                <td> <?php echo $date_manufacturing; ?></td>
              </tr>
              <tr>
                <td><b>Model:</b></td>
                <td> <?php echo $model; ?></td>
              </tr>
              <tr>
                <td><b>Type:</b> </td>
                <td> <?php echo $type; ?></td>
              </tr>
              <tr>
                <td><b>Multi Game:</b> </td>
                <td> <?php if ($type_player == "1") echo "YES";
                      else echo "NO"; ?></td>
              </tr>
              <tr>
                <td><b>Multi-terminal:</b></td>
                <td> <?php if ($multiterminal == "1") echo "YES";
                      else echo "NO"; ?></td>
              </tr>
              <tr>
                <td><b>State:</b> </td>
                <td> <?php if ($state == 1) echo "Commissioned";
                      else echo "Decommissioned"; ?></td>
              </tr>
              <tr>
                <td><b>Date commission:</b></td>
                <td> <?php echo $date_commission; ?></td>
              </tr>
              <tr>
                <?php
                if ($state == 0) {
                  echo "<label>Date decommission: " . $date_decommission . "</td>";
                }  ?>
              </tr>
            </table>
          </div>
          <div class="col-6">
            <h1>&nbsp;</h1>
            <div class="row">
            </div>
            <div class="row">
              <h2 style="margin-top: 20px; float : center;"><b>Motherboard Details</b></h2>
            </div>
            <div class="row mb-5">
              <table class="w3-table-all">
                <tr>
                  <td><b>Original:</td>
                  <td> <?php if ($is_original == "1") echo "YES";
                        else echo "NO"; ?></td>
                </tr>
                <tr>
                  <td><b>Serial Number:</td>
                  <td> <?php echo $serial_number_motherboard; ?></td>
                </tr>

                <tr>
                  <td><b>Manufacturer Motherboard:</td>
                  <td>
                    <?php
                    if ($id_manufacturer_motherboard) {
                      $query = "SELECT name_manufacturer FROM manufacturer WHERE id_manufacturer = " . $id_manufacturer_motherboard . ";";
                      if ($result = $connect->query($query)) {
                        $row = $result->fetch_assoc();
                        echo  $row["name_manufacturer"];
                      }
                    } else {
                      echo "Unknown";
                    }
                    ?>
                  </td>
                </tr>
              </table>
            </div>
            <div class="col-50">
              <fieldset>
                <legend style="text-align: left;">Power port</legend>
                <label>Jumper number: <?php echo $power_jumper_number; ?></label></br>
                <label>Jumper type: <?php echo $power_jumper_type; ?></label>
              </fieldset>
            </div>
            <div class="col-50">
              <fieldset>
                <legend style="text-align: left;">Com port</legend>
                <label>Jumper number: <?php echo $com_jumper_number; ?></label></br>
                <label>Jumper type: <?php echo $com_jumper_type; ?></label>
              </fieldset>
            </div>
            <div class="col-100-top">
              <table class="w3-table-all">
                <tr>
                  <td><b>Location in the Establishment:</b></td>
                </tr>
                <tr>
                  <td><?php if ($est_location != "") echo $est_location;
                      else echo "~"; ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <script type="text/javascript">
      $(window).on("load", function() {
        <?php if (isset($_GET["error"])) { ?>
          alert("<?php echo $_GET["error"]; ?>");
        <?php } ?>
      });

      function closeAdd() {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "slot.php");
        <?php if (isset($_POST['operator'])) { ?>
          var hiddenField2 = document.createElement("input");
          hiddenField2.setAttribute("type", "hidden");
          hiddenField2.setAttribute("name", "operator");
          hiddenField2.setAttribute("value", "<?php echo $_POST['operator']; ?>");
          form.appendChild(hiddenField2);
        <?php }
        if (isset($_POST['establishment'])) {  ?>
          var hiddenField = document.createElement("input");
          hiddenField.setAttribute("type", "hidden");
          hiddenField.setAttribute("name", "establishment");
          hiddenField.setAttribute("value", "<?php echo $_POST['establishment']; ?>");
          form.appendChild(hiddenField);
        <?php } ?>
        document.body.appendChild(form);
        form.submit();
      }

      function edit_slot(license) {
        bool = 1;
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "slot.php");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "slot");
        hiddenField.setAttribute("value", license);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
      }

      function show_tag(id) {
        bool = 1;
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "tag.php");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "slot");
        hiddenField.setAttribute("value", id);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
      }

      function info_slot(license) {
        bool = 1;
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "slot.php");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "slot_info");
        hiddenField.setAttribute("value", license);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
      }

      function showEstablishment() {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "establishment.php");
        var hiddenField2 = document.createElement("input");
        hiddenField2.setAttribute("type", "hidden");
        hiddenField2.setAttribute("name", "operator");
        hiddenField2.setAttribute("value", "<?php if (isset($_POST['operator'])) echo $_POST['operator']; ?>");
        form.appendChild(hiddenField2);
        document.body.appendChild(form);
        form.submit();
      }

      function show_image(id) {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "slot_images.php");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "slot");
        hiddenField.setAttribute("value", id);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
      }
      var bool = 0;
      $(document).ready(function() {

        $("#id_is_original").change(function() {
          if (this.checked) {
            $('#id_manufacturer_motherboard').val($("#manufacturerSelect").val());
            $('#id_manufacturer_motherboard_text').val($("#manufacturerSelect").val());
            $('#id_manufacturer_motherboard').attr('disabled', 'disabled');
          } else {
            $('#id_manufacturer_motherboard').attr('disabled', false);
          }
        });

        $("#state_id").change(function() {
          if ($(this).val() == "1") {
            document.getElementById('decommission').disabled = true;
            document.getElementById("decommission-div").style.display = "none";
          } else {
            document.getElementById('decommission').disabled = false;
            document.getElementById("decommission-div").style.display = "block";
          }
        });

        $("#id_manufacturer_motherboard").change(function() {
          $('#id_manufacturer_motherboard_text').val($("#id_manufacturer_motherboard").val());
        });

        $("#manufacturerSelect").change(function() {
          if ($("#id_is_original").is(':checked')) {
            $('#id_manufacturer_motherboard').val($("#manufacturerSelect").val());
            $('#id_manufacturer_motherboard_text').val($("#manufacturerSelect").val());
          }
          $("#model_id").empty();
          var value = $(this).val();
          if (value) {
            $.post('PHP/selectSlotModel.php', {
              manufacturer: value
            }, function(data) {
              if (data) {

                $("#model_id").append('<option></option>');
                data = data.substring(0, data.length - 1);
                var res = data.split(":");
                for (var i = 0; i < res.length; i += 2) {
                  $("#model_id").append('<option value=' + res[i] + '>' + res[i + 1] + '</option>');
                }
              }
            }).fail(function() {
              alert("Server error!");
            });
          }
        });

        $("#operator_id").change(function() {
          console.log("changed!")
          var operatorVal = $(this).val();
          $('#establishment_id option').remove()
          if (operatorVal) {
            document.getElementById("idDivShow").style.display = 'block';
            $("#establishment_id").attr('disabled', false);
            $.post('PHP/selectEstablishment.php', {
              operator: operatorVal
            }, function(data) {
              $('#establishment_id option').remove()
              if (data) {
                $("#establishment_id").append('<option></option>');
                data = data.substring(0, data.length - 1);
                var res = data.split(":");
                for (var i = 0; i < res.length; i += 2) {
                  $("#establishment_id").append('<option value=' + res[i] + '>' + res[i + 1] + '</option>');
                }
              } else {
                $("#establishment_id").attr('disabled', true);
              }
            }).fail(function() {
              alert("Server error!");
            });
          } else {
            document.getElementById("idDivShow").style.display = 'none';
            $("#establishment_id").attr('disabled', true);
          }

        });

        $("#myTable tr td:eq(0)").click(function() {
          $(this).addClass('selected').siblings().removeClass('selected');
          var value = $(this).find('td:nth-child(<?php if (isset($_POST['operator']) || isset($_POST['establishment'])) echo "1";
                                                  else echo "2"; ?>)').html();
          if ($(this).find('td:first') && bool == 0) {
            if (typeof value !== 'undefined' && value !== null) {
              var form = document.createElement("form");
              form.setAttribute("method", "post");
              form.setAttribute("action", "slot_images.php");
              var hiddenField = document.createElement("input");
              hiddenField.setAttribute("type", "hidden");
              hiddenField.setAttribute("name", "slot");
              hiddenField.setAttribute("value", value);
              form.appendChild(hiddenField);
              document.body.appendChild(form);
              form.submit();
            }
          } else if (bool == 1) {
            bool = 0;
          }
        });
      });
    </script>


  </div>
  <div id="id_add_slot" class="modal-div">
    <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
    <form class="modal-div-content" action="PHP/<?php if (isset($_POST['slot'])) echo "editSlot.php";
                                                else echo "addSlot.php"; ?>" method="POST">
      <div class="container">
        <h1><?php if (isset($_POST['slot'])) echo "Edit Slot";
            else echo "New Slot"; ?></h1>
        <hr>
        <label><b>Operator</b></label>
        <?php
        if (isset($_POST['operator'])) {
          $query = "SELECT * FROM operator WHERE official_license_number = \"" . $_POST['operator'] . "\";";
          $result = $connect->query($query);
          $row = $result->fetch_assoc(); ?>
          <input class="input-add" type="text" value="<?php echo $row['company_name']; ?>" readonly>
          <input id="fk_operator" type="text" name="fk_license_number_operator" value="<?php echo $row['license_number']; ?>" readonly>
        <?php } else if (isset($_POST['establishment'])) {
          $query = "SELECT * FROM operator, establishment WHERE license_number = fk_license_number_operator AND permit_number = " . $official_permit_license . ";";
          $result = $connect->query($query);
          $row = $result->fetch_assoc(); ?>
          <input class="input-add" type="text" value="<?php echo $row['company_name']; ?>" readonly>
          <input id="fk_operator" type="text" name="fk_license_number_operator" value="<?php echo $row['license_number']; ?>">
        <?php } else if (isset($_POST['slot'])) {
          $query = "SELECT * FROM slot_machines, operator WHERE license_number = fk_license_number AND serial_number = \"" . $serial_number . "\";";
          $result = $connect->query($query);
          $row = $result->fetch_assoc();
          $operator_slot_edit = $row['license_number']; ?>
          <input class="input-add" type="text" value="<?php echo $row['company_name']; ?>" readonly>
          <input id="fk_operator" type="text" name="fk_license_number_operator" value="<?php echo $operator_slot_edit; ?>">
        <?php } else { ?>
          <select id="operator_id" class="input-add" name="fk_license_number_operator" required>
            <option value=""></option>
          <?php
          $query = "SELECT * FROM operator;";
          if ($result = $connect->query($query)) {
            while ($row = $result->fetch_assoc()) {
              echo "<option value=\"" . $row['license_number'] . "\">" . $row['company_name'] . "</option>";
            }
          }
          echo "</select>";
        }
          ?>
          <?php
          if (isset($_POST['establishment']) || isset($_POST['operator']) || isset($_POST['slot'])) {
            echo "<div id=\"idDivShow\" style=\"display:block;\">";
          } else {
            echo "<div id=\"idDivShow\" style=\"display:none;\">";
          }
          ?>
          <label><b>Establishment</b></label>
          <?php
          if (isset($_POST['slot'])) { ?>

            <select class="input-add" name="license_establishment">

              <?php
              $query = "SELECT * FROM  slot_machines_establishment WHERE fk_slot_machines = \"" . $serial_number . "\";";
              $result = $connect->query($query);

              $slot_establishment = $result->fetch_assoc();
              print_r($slot_establishment['fk_slot_machines']);

              $query = "SELECT * FROM establishment WHERE fk_license_number_operator = " . $operator_slot_edit . ";";
              $result = $connect->query($query);
              while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row['permit_number'] . "\"";
                if ($slot_establishment['fk_establishment'] == $row['permit_number']) {
                  echo " selected";
                }
                echo ">" . $row['name'] . "</option>";
              }
              ?>
            </select>
          <?php } else if (isset($_POST['establishment'])) {
            $query = "SELECT * FROM establishment WHERE permit_number = " . $official_permit_license . ";";
            $result = $connect->query($query);
            $row = $result->fetch_assoc(); ?>
            <input class="input-add" type="text" value="<?php echo $row['name']; ?>" readonly>
            <input type="text" name="license_establishment" value="<?php echo $row['permit_number']; ?>" style="display:none;">
          <?php } else if (isset($_POST['operator'])) { ?>
            <select class="input-add" name="license_establishment">
              <option value="">
                </value>
                <?php
                $query = "SELECT * FROM establishment, operator WHERE fk_license_number_operator = license_number AND official_license_number = \"" . $_POST['operator'] . "\";";
                $result = $connect->query($query);
                while ($row = $result->fetch_assoc()) {
                  echo "<option value=\"" . $row['permit_number'] . "\">" . $row['name'] . " </option>";
                }
                ?>
            </select>
          <?php
          } else { ?>
            <select id="establishment_id" class="input-add" name="license_establishment" disabled></select>
          <?php } ?>


          <label><b>Serial Number</b></label>
          <input class="input-add" type="text" name="serial_number" value="<?php echo $serial_number; ?>" <?php if (isset($_POST['slot'])) echo "readonly";
                                                                                                          else echo "required"; ?>>
          <label><b>Regulator Number</b></label>
          <input class="input-add" type="text" name="regulator_number" value="<?php echo $regulator_number; ?>" required>
          <label><b>Operator Number</b></label>
          <input class="input-add" type="text" name="operator_number" value="<?php echo $operator_number; ?>" required>
          <label><b>Manufacturer</b></label>
          <select id="manufacturerSelect" class="input-add" name="manufacturer" required>
            <option value=""></option>
            <?php
            $query = "SELECT * FROM manufacturer;";
            if ($result = $connect->query($query)) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row['id_manufacturer'] . "\" ";
                if ($id_manufacturer == $row['id_manufacturer']) {
                  echo "selected";
                }
                echo ">" . $row['name_manufacturer'] . "</option>";
              }
            }
            ?>
          </select>
          <label><b>Date Manufacturing</b></label>
          <input class="input-add" type="date" name="date_manufacturing" value="<?php echo $date_manufacturing; ?>" required>
          <label><b>Model</b></label>
          <select id="model_id" class="input-add" name="model" required>
            <option value=""></option>
            <?php
            $query = "SELECT * FROM slot_model;";
            print_r($query);
            if ($result = $connect->query($query)) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row['id_model'] . "\" ";
                if ($id_model == $row['id_model']) {
                  echo "selected";
                }
                echo ">" . $row['name_model'] . "</option>";
              }
            }
            ?>
          </select>
          <label><b>Type</b></label></br>
          <select class="input-add" name="type" required>
            <option value=""></option>
            <?php
            $query = "SELECT * FROM type_slot_machines;";
            if ($result = $connect->query($query)) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row['id_type_slot_machines'] . "\" ";
                if ($id_type == $row['id_type_slot_machines']) {
                  echo "selected";
                }
                echo ">" . $row['name_type'] . "</option>";
              }
            }
            ?>
          </select>
          <label><b>Number of Game</b></label></br>
          <div class="col-100">
            <input type="radio" name="number_game" value="0" <?php if ($type_player == "0") echo "checked"; ?>> Single Game
            <input type="radio" name="number_game" value="1" <?php if ($type_player == "1") echo "checked"; ?>> Multi Game
            <input type="checkbox" name="multiterminal" value="1" <?php if ($multiterminal == "1") echo "checked"; ?>> Multi Terminal
          </div>
          <label><b>Location in the Establishment</b></label></br>
          <textarea class="input-add" name="est_location" rows="4" cols="50" maxlength="256"><?php echo $est_location; ?></textarea>
          <label><b>State</b></label>
          <select id="state_id" class="input-add" name="state" required>
            <option value="1" <?php if ($state == 1) echo "selected"; ?>>Commissioned</option>
            <option value="0" <?php if ($state == 0) echo "selected"; ?>>Decommissioned</option>
          </select>
          <label><b>Date Commission</b></label>
          <input class="input-add" type="date" name="date_commission" value="<?php echo $date_commission; ?>" required>
          <div id="decommission-div" <?php if ($state != 0) echo "style=\"display:none;\""; ?>>
            <label><b>Date Decommission</b></label>
            <input id="decommission" class="input-add" type="date" name="date_decommission" value="<?php if ($state == 0) echo $date_decommission; ?>" <?php if ($state != 0) echo "disabled"; ?>>
          </div>
          <label><b>Mainboard Details</b></label>
          <div class="col-100">
            <label><b>Mainboard Serial Number</b></label>
            <input type="text" name="serial_number_motherboard" value="<?php echo $serial_number_motherboard; ?>" required>

            <label><b>Mainboard Manufacturer</b></label>
            <input id="id_manufacturer_motherboard_text" class="input-add" name="manufacturer_motherboard" value="<?php echo $id_manufacturer_motherboard; ?>" style="display:none;">
            <select id="id_manufacturer_motherboard" class="input-add" <?php if ($is_original == "1") echo "disabled"; ?>>
              <option selected></option>
              <?php
              $query = "SELECT * FROM manufacturer;";
              if ($result = $connect->query($query)) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value=\"" . $row['id_manufacturer'] . "\" ";
                  if ($id_manufacturer_motherboard == $row['id_manufacturer']) {
                    echo "selected";
                  }
                  echo ">" . $row['name_manufacturer'] . "</option>";
                }
              }
              ?>
            </select>

            <p>
              <label>Original Mainboard &nbsp; </label>

              <input id="id_is_original" type="checkbox" name="is_original" value="1" <?php if ($is_original == "1") echo "checked"; ?>>

              Check if Yes
            </p>

            <label><b>Mainboard Model</b></label>
            <input type="text" name="model_motherboard" value="<?php echo $model_motherboard; ?>">
          </div>
          </br><label><b>Mainboard Jumper</b></label>
          <div class="col-100">
            <div class="col-50 text-left">
              <fieldset>
                <legend>Power port</legend>
                <label>Jumper number</label>
                <input type="text" name="power_jumper_number" value="<?php echo $power_jumper_number; ?>">
                <label>Jumper type</label>
                <input type="text" name="power_jumper_type" value="<?php echo $power_jumper_type; ?>">
              </fieldset>
            </div>
            <div class="col-50 text-left">
              <fieldset>
                <legend>Com port</legend>
                <label>Jumper number</label>
                <input type="text" name="com_jumper_number" value="<?php echo $com_jumper_number; ?>">
                <label>Jumper type</label>
                <input type="text" name="com_jumper_type" value="<?php echo $com_jumper_type; ?>">
              </fieldset>
            </div>
          </div>
          <div class="clearfix">
            <button type="submit" class="m-3 savebtn btn btn-lg btn-success">Save</button>
            <button type="button" onclick="closeAdd()" class="m-3  btn btn-lg btn-warning">Cancel</button>

          </div>
      </div>
    </form>
  </div>

</body>

</html>