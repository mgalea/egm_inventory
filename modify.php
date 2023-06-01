<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/modify.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="fontawesome/js/all.min.js"></script>
  <link rel="icon" href="favicon/favicon.ico">

  <script src="https://www.w3schools.com/lib/w3.js"></script>

  <script type="text/javascript">
    function searchInUsers() {
      // Declare variables
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td1 = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[1];
        if (td1) {
          if ((td1.innerHTML.toUpperCase().indexOf(filter) > -1) || (td2.innerHTML.toUpperCase().indexOf(filter) > -1)) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>

</head>

<body>
  <div class="header">
    <?php
    include 'header.php';
    include 'PHP/admin.php';
    ?>
  </div>

  <main class="flex-shrink-0">

    <div class="div-body">

      <style media="screen">
        <?php
        if (isset($_POST['user'])) {
          echo "
          .modal-div {
            display: block;
          }";
        };
        ?>
      </style>
      <?php
      $id_user = "";
      $user_type = "";
      $username = "";
      $email = "";
      $telephone = "";
      $organization = "";
      $active = "";
      $username = "";
      $firstname = "";
      $lastname = "";
      $user_role = "";
      $personalid = "";
      $image = "";

      if (isset($_POST['user'])) {
        $id_user = $_POST['user'];
      }
      if ($id_user != "") {
        $query = "SELECT * FROM users WHERE id = " . $id_user . ";";
        if ($result = $connect->query($query)) {
          $row = $result->fetch_assoc();
          $user_type = $row['user_type'];
          $username = $row['username'];
          $email = $row['email'];
          $telephone = $row['telephone'];
          $organization = $row['organization'];
          $active = $row['active'];
          $firstname = $row['first_name'];
          $lastname = $row['last_name'];
          $user_role = $row['role'];
          $personalid = $row['personal_id'];
          $image = $row['image'];
        }
      }

      if (isset($_POST['user_delete'])) {
        $id_user = $_POST['user_delete'];
        if ($id_user != "") {
          $query = "DELETE FROM users WHERE id = " . $id_user . ";";
          $connect->query($query);
        }
      }
      ?>

      <div id="id_add_user" class="modal-div">
        <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
        <form id="formAdd" onsubmit="return onSubmitFunction()" class="modal-div-content" action="PHP/<?php if (isset($_POST['user'])) echo "editUser.php";
                                                                                                      else echo "addUser.php"; ?>" method="POST">
          <div class="container">
            <h1><?php if (isset($_POST['user'])) echo "Edit User";
                else echo "New User"; ?></h1>
            <hr>
            <?php if (isset($_POST['user'])) { ?>
              <input type="text" name="id_user" value="<?php echo $id_user; ?>" style="display:none;">
            <?php } ?>
            <label><b>Username</b></label>
            <input class="input-add" type="text" name="username" value="<?php echo $username; ?>" required>

            <label><b>First Name</b></label>
            <input class="input-add" type="text" name="firstname" value="<?php echo $firstname; ?>" required>

            <label><b>Last Name</b></label>
            <input class="input-add" type="text" name="lastname" value="<?php echo $lastname; ?>" required>

            <label><b>Personal ID</b></label>
            <input class="input-add" type="text" name="personalid" value="<?php echo $personalid; ?>" required>


            <label><b>Password</b></label>
            <input id="password" class="input-add" type="password" name="password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
            <label><b>Confirm Password</b></label>
            <input id="password_confirm" class="input-add" type="password" name="confirm-password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>

            <label><b>Type of User</b></label>
            <select class="input-add" name="type-user">
              <?php
              $query = "SELECT * FROM type_user;";
              if ($result = $connect->query($query)) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value=\"" . $row['id_type_user'] . "\" ";
                  if ($row['id_type_user'] == $user_type) {
                    echo "selected ";
                  }
                  echo ">" . $row['type_value'] . "</option>";
                }
              }
              ?>
            </select>
            <label><b>Email</b></label>
            <input class="input-add" type="text" name="email" value="<?php echo $email; ?>" required>
            <label><b>Telephone</b></label>
            <input class="input-add" type="text" name="telephone" value="<?php echo $telephone; ?>" required>
            <label><b>Organization</b></label>
            <input class="input-add" type="text" name="organization" value="<?php echo $organization; ?>" required>
            <label><b>State</b></label></br>
            <input type="checkbox" name="active" value="1" <?php if (!isset($_POST['user']) || $active == "1") echo "checked"; ?>> Enabled
            <div class="clearfix">
              <button type="button" onclick="closeAdd()" class="mx-3 cancelbtn btn btn-lg btn-warning">Cancel</button>
              <button type="submit" class="mx-3 btn btn-lg btn-success savebtn">Save</button>
            </div>
          </div>
        </form>
      </div>

      <div id="id_add_brand_operator" class="modal-div-modify">
        <span onclick="closeModify()" class="close_add" title="Close">&times;</span>
        <form id="formAddBrandOperator" class="modal-div-content" action="PHP/add_brand_operator.php" method="POST">
          <div class="container-fluid">
            <h1>Operators Brand</h1>
            <hr>
            <h5><b>Operator Brands</b></h5>
            <textarea id="w3review" name="w3review" rows="5" cols="30" class="mb-3 p-2">

            <?php
            $query = "SELECT * FROM brand;";
            $result = $connect->query($query);

            while ($row = $result->fetch_assoc()) {
              echo  trim($row["name"]) . "&#13;&#10;";
            }
            ?>
            </textarea>
            <input id="brandOperatorPHP" name="brandOperatorPHP" type="hidden" class="mt-2">
            <div class="col-100-add">
              <div id="div-new-brand-operator" class="col-100-add"></div>
              <div class="col-100-add">
                <div id="div-new" class="col-100-add"></div>
                <div class="col-100-58">
                  <input id="brandOperator" type="text" placeholder="Add a brand" class="input-select-add focus-ring">
                </div>

                <button id="addBrandOperator" type="button"></button>

              </div>
            </div>
            <div class="clearfix">
              <button type="submit" class="m-3 btn btn-lg btn-primary savebtn">Save</button>
              <button type="button" onclick="closeModify()" class="m-3 cancelbtn btn btn-lg btn-warning">Cancel</button>

            </div>
          </div>
        </form>
      </div>

      <div id="id_add_type_establishment" class="modal-div-modify">
        <span onclick="closeModify()" class="close_add" title="Close">&times;</span>
        <form id="formAddTypeEstablishment" class="modal-div-content" action="PHP/add_type_establishment.php" method="POST">
          <div class="container">
            <h1>Location Types</h1>
            <hr>
            <?php
            $query = "SELECT * FROM type;";
            $result = $connect->query($query);
            while ($row = $result->fetch_assoc()) {
              echo "<input type=\"text\" class=\"input-disabled\" value=\"" . $row["namet"] . "\" disabled>";
            }
            ?>

            <input id="typeEstablishmentPHP" name="typeEstablishmentPHP" type="text">
            <div class="col-100-add">
              <div id="div-new-type-establishment" class="col-100-add"></div>
              <div class="col-100-add input-add">
                <div class="col-100-58">
                  <input id="typeEstablishment" placeholder="Add Establishment" type="text" class="input-select-add">
                </div>
                <div class="col-58">
                  <button id="addTypeEstablishment" type="button"></button>
                </div>
              </div>
            </div>
            <div class="clearfix">
              <button type="submit" class="m-3 btn btn-lg btn-primary savebtn">Save</button>
              <button type="button" onclick="closeModify()" class="m-3 cancelbtn btn btn-lg btn-warning">Cancel</button>

            </div>
          </div>
        </form>
      </div>

      <div id="id_add_manufacturer_slots" class="modal-div-modify">
        <span onclick="closeModify()" class="close_add" title="Close">&times;</span>
        <form id="formAddManufacturerSlots" class="modal-div-content" action="PHP/add_manufacturer_slots.php" method="POST">
          <div class="container">
            <h1>Slots Manufacturer</h1>
            <hr>
            <?php
            $query = "SELECT * FROM manufacturer;";
            $result = $connect->query($query);
            while ($row = $result->fetch_assoc()) {
              echo "<input type=\"text\" class=\"input-disabled\" value=\"" . $row["name_manufacturer"] . "\" disabled>";
            }
            ?>

            <input id="manufacturerSlotPHP" name="manufacturerSlotPHP" type="text">
            <div class="col-100-add">
              <div id="div-new-manufacturer-slots" class="col-100-add"></div>
              <div class="col-100-add input-add">
                <div class="col-100-58">
                  <input id="manufacturerSlot" type="text" placeholder="Add Manufacturer" class="input-select-add">
                </div>
                <div class="col-58">
                  <button id="addManufacturerSlot" type="button"></button>
                </div>
              </div>
            </div>
            <div class="clearfix">
              <button type="button" onclick="closeModify()" class="m-3 btn btn-lg btn-warning cancelbtn">Cancel</button>
              <button type="submit" class="m-3 btn btn-lg btn-primary savebtn">Save</button>
            </div>
          </div>
        </form>
      </div>

      <div id="id_add_type_slots" class="modal-div-modify">
        <span onclick="closeModify()" class="close_add" title="Close">&times;</span>
        <form id="formAddTypeSlots" class="modal-div-content" action="PHP/add_type_slots.php" method="POST">
          <div class="container">
            <h1>Slots Types</h1>
            <hr>
            <?php
            $query = "SELECT * FROM type_slot_machines;";
            $result = $connect->query($query);
            while ($row = $result->fetch_assoc()) {
              echo "<input type=\"text\" class=\"input-disabled\" value=\"" . $row["name_type"] . "\" disabled>";
            }
            ?>

            <input id="typeSlotsPHP" name="typeSlotsPHP" type="text">
            <div class="col-100-add">
              <div id="div-new-type-slots" class="col-100-add"></div>
              <div class="col-100-add input-add">
                <div class="col-100-58">
                  <input id="typeSlots" type="text" class="input-select-add"  placeholder="Add Slot Types ...">
                </div>
                <div class="col-58">
                  <button id="addTypeSlots" type="button"></button>
                </div>
              </div>
            </div>
            <div class="clearfix">
              <button type="submit" class="m-3 btn btn-lg btn-success savebtn">Save</button>
              <button type="button" onclick="closeModify()" class="m-3 cancelbtn btn btn-lg btn-warning">Cancel</button>
            </div>
          </div>
        </form>
      </div>

      <div id="id_add_model_slots" class="modal-div-modify">
        <span onclick="closeModify()" class="close_add" title="Close">&times;</span>

        

        <form id="formAddModelSlots" class="modal-div-content" action="PHP/add_model_slots.php" method="POST">

          <div class="container">
          <h2 id="slot_model_title">Slots Model</h2>


            <div class="tab" style="display: block;">
              <h4><b>Select the Slots manufacturer first.</b></h4>
              <hr>

              <table class="w3-table-all">
                <tr>
                  <th class="w3-dark-grey w3-hover-black">Manufacturer</th>
                </tr>
                <?php
                if ($connect) {
                  $query = "SELECT * from manufacturer;";
                  if ($result = $connect->query($query)) {
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr style=\"cursor:pointer\" onclick=\"selectManufacturerModel(" . $row["id_manufacturer"] . ",'" . $row["name_manufacturer"] . "')\" class=\"item float-start\"><td>" . $row["name_manufacturer"] . "&nbsp; &nbsp;</td></tr>";
                      }
                    }
                  }
                }
                ?>
              </table>
              <button type="button" onclick="closeModify()" class="m-3 btn btn-lg btn-warning cancelbtn">Cancel</button>
              <div class="clearfix"></div>
            </div>


            <div class="tab">
              <input id="manufacturerModelSlotsPHP" name="manufacturerModelSlotsPHP" type="hidden" value="">
              <input id="modelSlotsPHP" name="modelSlotsPHP" type="hidden" value="">
              <div class="col-100-add">
                <div id="div-new-model-slots" class="col-100-add"></div>
                <div class="col-100-add input-add">
                  <div class="col-100-58">
                    <input id="modelSlots" type="text" placeholder="Add Slot Model ..." class="input-select-add">
                  </div>
                  <div class="col-58">
                    <button id="addModelSlots" type="button">
                  </div>
                </div>
              </div>
              <div class="clearfix">
                <button type="button" onclick="backSelectManufacturerModel()" class="cancelbtn btn btn-lg btn-warning m-3">Cancel</button>
                <button type="submit" class="btn btn-lg btn-primary savebtn m-3">Save</button>
              </div>
            </div>

          </div>
        </form>

      </div>


      <div id="id_user_permissions" class="modal-div-modify">
        <span onclick="closeModify()" class="close_add" title="Close">&times;</span>
        <form id="formUserPermissions" class="modal-div-content" action="PHP/user_permissions.php" method="POST">
          <div class="container">
            <h1>User Permissions:</h1>
            <hr>
            <?php
            $query = "SELECT * FROM permissions;";
            $result = $connect->query($query);

            echo "<div class='row'>";
            for ($i = 1; $i <= $result->num_rows; $i++) {
              echo "<div class='col-3'>";
              if ($row = $result->fetch_assoc()) {
                $query = "SELECT count(*) as total FROM users_permissions where  user_id=" . $_SESSION['user_id'] . " AND permission_id=" . $row["id"] . ";";
                $result2 = $connect->query($query);
                $row2 = $result2->fetch_assoc();
            ?>
                <div class="form-check form-control-lg">
                  <input type="checkbox" value="<?php echo $row["id"] ?>" class="form-check-input " id="flexCheck<?php echo $row["id"] ?>" name="Check[<?php echo $row["id"] ?>]" <?php echo $row2["total"] ? "checked" : "" ?>>
                  <label class="form-check-label" for="flexCheck<?php echo $row["id"] ?>">
                    <?php echo $row["permission"]  ?>
                  </label>
                </div>
            <?php }
              echo "</div>";
            }
            echo "</div>";
            ?>

            <div class="clearfix">
              <button type="submit" class="m-3 btn btn-lg btn-primary savebtn">Save</button>
              <button type="button" onclick="closeModify()" class="m-3 cancelbtn btn btn-lg btn-warning">Cancel</button>

            </div>
          </div>
        </form>
      </div>

      <div class="container-fluid">

        <div class="btn-group d-flex btn-group-lg" role="group" aria-label="Settings">

          <button class="btn btn-secondary btn-default w-100" onclick="document.getElementById('id_add_brand_operator').style.display='block'">Operators Brands</button>

          <button class="btn btn-secondary btn-default w-100" onclick="document.getElementById('id_add_type_establishment').style.display='block'">Location Types</button>

          <button class="btn btn-secondary btn-default w-100" onclick="document.getElementById('id_add_manufacturer_slots').style.display='block'">Slots Manufacturers</button>

          <button class="btn btn-secondary btn-default w-100" onclick="document.getElementById('id_add_model_slots').style.display='block'">Slots Models</button>

          <button class="btn btn-secondary btn-default w-100" onclick="document.getElementById('id_add_manual_slots').style.display='block'">Slots Manuals</button>

          <button class="btn btn-secondary btn-default w-100" onclick="document.getElementById('id_add_type_slots').style.display='block'">Slots Types</button>

          <button class="btn btn-secondary btn-default w-100" onclick="db_dump()">DB Dump</button>

        </div>


        <h1 class="pt-4 pb-2">Users</h1>


        <div class="row mb-3">
          <div class="col-6">
            <input type="text" id="myInput" onkeyup="searchInUsers()" placeholder="Search Users ...">
          </div>
          <div class="col-6 ">
            <button class="btn btn-lg btn-primary " onclick="document.getElementById('id_add_user').style.display='block'">Add User</button>
          </div>
        </div>

        <div class="row mb-5">
          <div class="col-12">
            <table id="myTable" class="w3-table-all">
              <tr>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Username <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">User Type <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Email <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(4)')" style="cursor:pointer">Phone <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(5)')" style="cursor:pointer;text-align: center">Organization <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(6)')" style="cursor:pointer;text-align: center">State <i class="fa fa-sort" style="font-size:13px;"></i></th>
                <th class="w3-dark-grey w3-hover-black" style="cursor:pointer;text-align: center">Action</th>
              </tr>
              <?php
              if ($connect) {
                $query = "SELECT * from users, type_user WHERE user_type = id_type_user;";
                if ($result = $connect->query($query)) {
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $state = "";
                      if ($row["active"] == "1") {
                        $state = "Enabled";
                      } else {
                        $state = "Disabled";
                      }
                      $o = "<tr class=\"item\"><td>" . $row["username"] . "</td><td>" . (($row["id"] == 1) ? "Super Adminsitrator" : $row["type_value"]) . "</td><td>" . $row["email"] . "</td><td>" . $row["telephone"] . "</td><td style='text-align: center'>" . $row["organization"] . "</td><td style='text-align: center'>" . $state;
                      $o =  ($row["id"] == 1) ? $o . "<td></td></tr>" : $o . "</td><td style='text-align: center' ><i onclick=\"edit_user(" . $row["id"] . ")\" class='fa-light fa-2x fa-pencil px-2' data-toggle='tooltip' data-placement='bottom' title='Edit'></i><i onclick=\"document.getElementById('id_user_permissions').style.display='block'\" class='fa-light fa-2x fa-eye px-2' data-toggle='Permissions' data-placement='bottom' title='Permissions'></i><i onclick=\"delete_user(" . $row["id"] . ")\" class='fa-light fa-2x fa-trash px-2' data-toggle='tooltip' data-placement='bottom' title='Delete'></i></td></tr>";
                      echo  $o;
                    }
                  }
                }
              }
              ?>
            </table>
          </div>
        </div>
      </div>
  </main>
  <div class="footer mt-auto">
    <?php
    include 'footer.php';
    ?>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script type="text/javascript">
  var currentTab = 0; // Current tab is set to be the first tab (0)
  showTab(currentTab); // Display the crurrent tab

  function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:

  }


  var arrayModelSlot = [];
  var arrayModelSlot_del;
  var arrayManufacturerSlot = [];
  var arrayManufacturerSlot_del;
  var arrayTypeSlots = [];
  var arrayTypeSlots_del;
  var arrayTypeEstablishment = [];
  var arrayTypeEstablishment_del;
  var arrayBrandOperator = [];
  var arrayBrandOperator_del;

  var container_manufacturer_slots = document.getElementById("div-new-manufacturer-slots");
  var container_model_slots = document.getElementById("div-new-model-slots");
  var container_type_slots = document.getElementById("div-new-type-slots");
  var container_type_establishment = document.getElementById("div-new-type-establishment");
  var container_brand_operator = document.getElementById("div-new-brand-operator");

  $(window).on("load", function() {
    <?php if (isset($_GET["error"])) { ?>
      alert("<?php echo $_GET["error"]; ?>");
    <?php } ?>
  });

  function db_dump() {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "PHP/dbdump.php");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "filename");
    hiddenField.setAttribute("value", 'db_dump.sql');
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
  }

  function closeAdd() {
    document.location.href = "modify.php";
  }

  function closeModify() {
    document.location.href = "modify.php";
  }

  document.getElementById('addModelSlots').addEventListener('click', function() {
    if (document.getElementById("modelSlots").value != "") {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "member";
      input.style.float = "left";
      input.style.width = "calc(100% - 58px)";
      input.style.marginTop = "2px";
      input.style.marginBottom = "2px";
      input.readOnly = true;
      input.value = document.getElementById("modelSlots").value;
      container_model_slots.appendChild(input);

      var buttonAdd = document.createElement("button");
      buttonAdd.setAttribute('type', 'button');
      buttonAdd.classList.add("delType");
      buttonAdd.addEventListener('click', function() {
        container_model_slots.removeChild(buttonAdd);
        container_model_slots.removeChild(input);
        arrayModelSlot_del = input.value;
        updateModelSlot();
      });
      container_model_slots.appendChild(buttonAdd);

      arrayModelSlot.push(document.getElementById("modelSlots").value);
      updateModelSlot();
      document.getElementById("modelSlots").value = "";
    }
  });

  function updateModelSlot() {
    console.log = "Im here";
    var array = [];
    for (var i = 0; i < arrayModelSlot.length; i++) {
      if (arrayModelSlot[i] != arrayModelSlot_del) {
        array.push(arrayModelSlot[i]);
      }
    }
    arrayModelSlot = array;
    arrayModelSlot_del = "";
    if (array) {
      document.getElementById("modelSlotsPHP").value = array.toString();
    }
  }

  document.getElementById('addManufacturerSlot').addEventListener('click', function() {

    if (document.getElementById("manufacturerSlot").value != "") {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "member";
      input.style.float = "left";
      input.style.width = "calc(100% - 58px)";
      input.style.marginTop = "2px";
      input.style.marginBottom = "2px";
      input.readOnly = true;
      input.value = document.getElementById("manufacturerSlot").value;
      container_manufacturer_slots.appendChild(input);

      var buttonAdd = document.createElement("button");
      buttonAdd.setAttribute('type', 'button');
      buttonAdd.classList.add("delType");
      buttonAdd.addEventListener('click', function() {
        container_manufacturer_slots.removeChild(buttonAdd);
        container_manufacturer_slots.removeChild(input);
        arrayManufacturerSlot_del = input.value;
        updateManufacturerSlot();
      });
      container_manufacturer_slots.appendChild(buttonAdd);
      arrayManufacturerSlot.push(document.getElementById("manufacturerSlot").value);
      updateManufacturerSlot();
      document.getElementById("manufacturerSlot").value = "";
    }
  });

  function updateManufacturerSlot() {
    var array = [];
    for (var i = 0; i < arrayManufacturerSlot.length; i++) {
      if (arrayManufacturerSlot[i] != arrayManufacturerSlot_del) {
        array.push(arrayManufacturerSlot[i]);
      }
    }
    arrayManufacturerSlot = array;
    arrayManufacturerSlot_del = "";
    document.getElementById("manufacturerSlotPHP").value = array;
  }

  document.getElementById('addTypeSlots').addEventListener('click', function() {

    if (document.getElementById("typeSlots").value != "") {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "member";
      input.style.float = "left";
      input.style.width = "calc(100% - 58px)";
      input.style.marginTop = "2px";
      input.style.marginBottom = "2px";
      input.readOnly = true;
      input.value = document.getElementById("typeSlots").value;
      container_type_slots.appendChild(input);

      var buttonAdd = document.createElement("button");
      buttonAdd.setAttribute('type', 'button');
      buttonAdd.classList.add("delType");
      buttonAdd.addEventListener('click', function() {
        container_type_slots.removeChild(buttonAdd);
        container_type_slots.removeChild(input);
        arrayTypeSlots_del = input.value;
        updateTypeSlots();
      });
      container_type_slots.appendChild(buttonAdd);
      arrayTypeSlots.push(document.getElementById("typeSlots").value);
      updateTypeSlots();
      document.getElementById("typeSlots").value = "";
    }
  });

  function updateTypeSlots() {
    var array = [];
    for (var i = 0; i < arrayTypeSlots.length; i++) {
      if (arrayTypeSlots[i] != arrayTypeSlots_del) {
        array.push(arrayTypeSlots[i]);
      }
    }
    arrayTypeSlots = array;
    arrayTypeSlots_del = "";
    document.getElementById("typeSlotsPHP").value = array;
  }

  document.getElementById('addTypeEstablishment').addEventListener('click', function() {

    if (document.getElementById("typeEstablishment").value != "") {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "member";
      input.style.float = "left";
      input.style.width = "calc(100% - 58px)";
      input.style.marginTop = "2px";
      input.style.marginBottom = "2px";
      input.readOnly = true;
      input.value = document.getElementById("typeEstablishment").value;
      container_type_establishment.appendChild(input);

      var buttonAdd = document.createElement("button");
      buttonAdd.setAttribute('type', 'button');
      buttonAdd.classList.add("delType");
      buttonAdd.addEventListener('click', function() {
        container_type_establishment.removeChild(buttonAdd);
        container_type_establishment.removeChild(input);
        arrayTypeEstablishment_del = input.value;
        updateTypeEstablishment();
      });
      container_type_establishment.appendChild(buttonAdd);
      arrayTypeEstablishment.push(document.getElementById("typeEstablishment").value);
      updateTypeEstablishment();
      document.getElementById("typeEstablishment").value = "";
    }
  });

  function updateTypeEstablishment() {
    var array = [];
    for (var i = 0; i < arrayTypeEstablishment.length; i++) {
      if (arrayTypeEstablishment[i] != arrayTypeEstablishment_del) {
        array.push(arrayTypeEstablishment[i]);
      }
    }
    arrayTypeEstablishment = array;
    arrayTypeEstablishment_del = "";
    document.getElementById("typeEstablishmentPHP").value = array;
  }

  document.getElementById('addBrandOperator').addEventListener('click', function() {

    if (document.getElementById("brandOperator").value != "") {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "member";
      input.style.float = "left";
      input.style.width = "calc(100% - 58px)";
      input.style.marginTop = "2px";
      input.style.marginBottom = "2px";
      input.readOnly = true;
      input.value = document.getElementById("brandOperator").value;
      container_brand_operator.appendChild(input);

      var buttonAdd = document.createElement("button");
      buttonAdd.setAttribute('type', 'button');
      buttonAdd.classList.add("delType");
      buttonAdd.addEventListener('click', function() {
        container_brand_operator.removeChild(buttonAdd);
        container_brand_operator.removeChild(input);
        arrayBrandOperator_del = input.value;
        updateBrandOperator();
      });
      container_brand_operator.appendChild(buttonAdd);
      arrayBrandOperator.push(document.getElementById("brandOperator").value);
      updateBrandOperator();
      document.getElementById("brandOperator").value = "";
    }
  });

  function updateBrandOperator() {
    var array = [];
    for (var i = 0; i < arrayBrandOperator.length; i++) {
      if (arrayBrandOperator[i] != arrayBrandOperator_del) {
        array.push(arrayBrandOperator[i]);
      }
    }
    arrayBrandOperator = array;
    arrayBrandOperator_del = "";
    document.getElementById("brandOperatorPHP").value = array;
  }

  function edit_user(license) {
    bool = 1;
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "modify.php");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "user");
    hiddenField.setAttribute("value", license);
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
  }

  function delete_user(id) {
    if (id == 1) {
      alert("You cannot delete Administrator?");
      return;
    }
    alert("Are you sure you want to delete User?");
    bool = 1;
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "modify.php");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "user_delete");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
  }

  function permission_user(id) {
    if (id == 1) {
      alert("You cannot change Administrator Permissions.");
      return;
    }
    bool = 1;
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "modify.php");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "user_permission");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
  }


  function selectManufacturerModel(value, valueText) {

    $("#div-new-model-slots").empty();
    $("#manufacturerModelSlotsPHP").val(value);

    document.getElementById("slot_model_title").innerHTML = ('Slots Model for ' + valueText);
    var x = document.getElementsByClassName("tab");
    x[currentTab].style.display = "none";
    currentTab = 1;

    $.post('PHP/selectSlotModel.php', {
      manufacturer: value
    }, function(data) {
      if (data) {
        data = data.substring(0, data.length - 1);
        datas = data.split(":");
        for (var i = 0; i < datas.length; i += 2) {
          var input = document.createElement("input");
          input.type = "text";
          input.name = "member";
          input.style.float = "left";
          input.style.width = "100%";
          input.style.marginTop = "2px";
          input.style.marginBottom = "2px";
          input.readOnly = true;
          input.value = datas[i + 1];
          container_model_slots.appendChild(input);
          arrayManufacturerSlot.push(datas[i + 1]);
        }
        updateModelSlot();
      }
    }).fail(function() {
      alert("Server error!");
    });
    showTab(currentTab);
  }

  function backSelectManufacturerModel() {
    document.getElementById("slot_model_title").innerHTML = 'Slots Model';
    var x = document.getElementsByClassName("tab");
    x[currentTab].style.display = "none";
    currentTab = 0;
    showTab(currentTab);
  }

  function onSubmitFunction() {
    <?php if (!isset($_POST['user'])) { ?>
      if ((document.getElementById("password").value != document.getElementById("password_confirm").value)) {
        alert("Passwords not the same!");
        return false;
      }
    <?php } ?>
    return true;
  };
</script>

</html>