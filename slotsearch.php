  <div class="container-fluid align-self-stretch">
    <div class="row pt-5">
    </div>
    <div class="row pt-5">
    <div class="col-lg-4 col-sm-1"></div>
      <div class="col-lg-4 col-sm-10 d-flex">
        <div class="btn-group btn-group-lg flex-fill " role="group" aria-label="Basic radio toggle button group" >
          <input name="btnradio" id="btnradio1" type="radio" class="btn-check bg-secondary  flex-fill" onclick="setSearchAttr(0)" autocomplete="off" checked >
          <label class="btn btn-outline-secondary" for="btnradio1"><h3>Tag</h3></label>

          <input name="btnradio" id="btnradio2" type="radio" class="btn-check btn-primary  flex-fill" onclick="setSearchAttr(1)" autocomplete="off">
          <label class="btn btn-outline-secondary" for="btnradio2"><h3>Serial</h3></label>
          <input name="btnradio" id="btnradio3" type="radio" class="btn-check btn-primary  flex-fill " onclick="setSearchAttr(2)" autocomplete="off">
          <label class="btn btn-outline-secondary" for="btnradio3"><h3>Inventory</h3></label>
        </div>
      </div>
      <div class="col-lg-4 col-sm-1"></div>
    </div>
    <div class="row pt-5">
      <div class="col-lg-4 col-sm-1"></div>
      <div class="col-lg-4 col-sm-10">
        <input autofocus="true" type="text" class="form-control fs-1" id="searchbox" placeholder="Search Slots by Tag Number ...">
      </div>
    </div>
    <div class="col-lg-4 col-sm-1"></div>
    <div class="row pt-5">
      <div class="col-lg-4 col-sm-1"></div>
      <div class="col-lg-4 col-sm-10 text-center">
        <button class="btn btn-lg btn-success  fs-2" onclick="info_slot(document.getElementById('searchbox').value)">Search </button>
      </div>
      <div class="col-lg-4 col-sm-1"></div>
    </div>

    <div class="row mx-justify-content-center mt-5">

    </div>

    <div id="spinner" class="lds-spinner">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>

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


    if (isset($_POST['slot_info'])) {
      $seal_number = $_POST['slot_info'];
      if ($connect && $seal_number != "") {


        switch ($_POST['type']) {
          case "0":
            $query = "SELECT * FROM slot_machines, manufacturer, type_slot_machines, slot_model, tag 
            WHERE tag_number=\"" . $seal_number . "\"
            AND slot_machines.serial_number = tag.fk_serial_number 
            AND slot_machines.fk_slot_type=type_slot_machines.id_type_slot_machines 
            AND fk_model=slot_model.id_model 
            AND slot_model.fk_id_manufacturer=manufacturer.id_manufacturer;";
            break;

          case "1":
            $query = "SELECT * FROM slot_machines, manufacturer, type_slot_machines, slot_model, tag 
            WHERE serial_number=\"" . $seal_number . "\"
            AND slot_machines.serial_number = tag.fk_serial_number 
            AND slot_machines.fk_slot_type=type_slot_machines.id_type_slot_machines 
            AND fk_model=slot_model.id_model 
            AND slot_model.fk_id_manufacturer=manufacturer.id_manufacturer;";
            break;

          case "2":
            $query = "SELECT * FROM slot_machines, manufacturer, type_slot_machines, slot_model, tag 
            WHERE reg_number=\"" . $seal_number . "\"
            AND slot_machines.serial_number = tag.fk_serial_number 
            AND slot_machines.fk_slot_type=type_slot_machines.id_type_slot_machines 
            AND fk_model=slot_model.id_model 
            AND slot_model.fk_id_manufacturer=manufacturer.id_manufacturer;";
            break;

          default:
            $query = "SELECT * FROM slot_machines, manufacturer, type_slot_machines, slot_model, tag 
          WHERE tag_number=\"" . $seal_number . "\"
          AND slot_machines.serial_number = tag.fk_serial_number 
          AND slot_machines.fk_slot_type=type_slot_machines.id_type_slot_machines 
          AND fk_model=slot_model.id_model 
          AND slot_model.fk_id_manufacturer=manufacturer.id_manufacturer;";
        }


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
            $serial_number = $row["serial_number"];

            $query = "SELECT fk_establishment, name FROM slot_machines_establishment, establishment WHERE fk_slot_machines = '$serial_number';";
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
            echo "
          <style>
              .modal-div-info {
                display: block;
              }
          </style>";
          } else {

            echo "
          <style>
              .modal-div-error {
                display: block;
              }
          </style>";
          }
        }
      } else {
        echo $connect->error;
      }
    }


    ?>

   <div id="id_info_slot" class="modal-div-info">
      <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
      <div class="modal-div-content">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <h1 style="margin-top: 20px; float : center;"><b>EGM Details</b></h1>
              <table class="w3-table-all w3-responsive" width="100%">
                <tr>
                  <td><b> Serial Number:</b></td>
                  <td> <?php echo $serial_number; ?></td>
                </tr>
                <tr>
                  <td><b> Tag Number:</b></td>
                  <td> <?php echo $seal_number; ?></td>
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

          </div>
        </div>
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript">
        $(window).on("load", function() {
          <?php if (isset($_GET["error"])) { ?>
            alert("<?php echo $_GET["error"]; ?>");
          <?php } ?>
        });


        function closeAdd() {
          var form = document.createElement("form");
          form.setAttribute("method", "post");
          form.setAttribute("action", "index.php");
          document.body.appendChild(form);
          form.submit();
        }

        TimeOutHandler = new Object();

        elem = document.getElementById("searchbox");

        function InputtingObserver(elem, inputCallback, observationDelay) {

          elem.addEventListener('input', () => {
            this.CallbackInterface(elem, inputCallback, observationDelay);
          });
        }

        function CallbackInterface(elem, firedCallback, DelayFromLast) {
          tmh = TimeOutHandler[elem]
          if (tmh) {
            window.clearTimeout(tmh);
          }
          TimeOutHandler[elem] = window.setTimeout(firedCallback, DelayFromLast);
        }

        InputtingObserver(elem, changed, 200);

        function changed() {
          info_slot(elem.value);
        }


        $(document).ready(function() {

          $(function() {
            $("#searchbox").focus();

          });

        });
      </script>


    </div>

    <div id="slot_not_found" class="modal-div-error">
      <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
      <div class="modal-div-content">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 style="margin-top: 20px; float : center;"><b>EGM Details not found</b></h1>

            </div>
          </div>
        </div>
      </div>
    </div>


    <script type="text/javascript">
      $(window).on("load", function() {
        <?php if (isset($_GET["error"])) { ?>
          alert("<?php echo $_GET["error"]; ?>");
        <?php } ?>
      });

      var searchAttr = 0;

      function setSearchAttr(id) {

        switch (id) {
          case 0:
            searchAttr = 0;
            document.getElementById('searchbox').placeholder = 'Search Slots by Tag Number...';
            InputtingObserver(elem, changed, 200);
            break;
          case 1:
            searchAttr = 1;
            document.getElementById('searchbox').placeholder = 'Search Slots by Serial Number...';
            InputtingObserver(elem, changed, 5000);
            break;

          case 2:
            searchAttr = 2;
            document.getElementById('searchbox').placeholder = 'Search Slots by Inventory Number...';
            InputtingObserver(elem, changed, 5000);
            break;
          default:
            searchAttr = 0;
            InputtingObserver(elem, changed, 5000);
        }

        $("#searchbox").focus();

      }

      function closeAdd() {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "index.php");
        document.body.appendChild(form);
        form.submit();
      }

      function info_slot(id) {

        if ((id == null || id == "")) {
          alert("Please Fill In All Required Fields");
          $("#searchbox").focus();
          return false;
        }
        bool = 1;
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "index.php");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "slot_info");
        hiddenField.setAttribute("value", id);
        form.appendChild(hiddenField);

        var hiddenField2 = document.createElement("input");
        hiddenField2.setAttribute("type", "hidden");
        hiddenField2.setAttribute("name", "type");
        hiddenField2.setAttribute("value", searchAttr);
        form.appendChild(hiddenField2);

        document.body.appendChild(form);
        form.submit();
      }

      TimeOutHandler = new Object();
      var timeout = 200;

      elem = document.getElementById("searchbox");

      function InputtingObserver(elem, inputCallback, observationDelay) {

        elem.addEventListener('input', () => {
          this.CallbackInterface(elem, inputCallback, observationDelay);
        });
      }

      function CallbackInterface(elem, firedCallback, DelayFromLast) {
        tmh = TimeOutHandler[elem]
        if (tmh) {
          window.clearTimeout(tmh);
        }
        TimeOutHandler[elem] = window.setTimeout(firedCallback, DelayFromLast);
      }

      InputtingObserver(elem, changed, timeout);

      function changed() {
        document.getElementById("spinner").style.display = "block";
        info_slot(elem.value)
      }

      $(document).ready(function() {

        $(function() {
          $("#searchbox").focus();

        });

      });
    </script>


  </div>