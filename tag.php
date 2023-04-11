<!DOCTYPE html>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://kit.fontawesome.com/8be26e49e1.js" crossorigin="anonymous"></script>
<link rel="icon" href="favicon/favicon.ico">

<script src="https://www.w3schools.com/lib/w3.js"></script>

<script type="text/javascript">
  function searchInTags() {
    // Declare variables
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

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
      <div class="row mb-2">
        <div class="col-12">

          <?php
          if (isset($_POST['slot'])) {
            echo "<h1>Tag History</h1>";
            echo "<h3><span class='badge bg-dark'>Slot Serial Number: " . $_POST['slot'] . "</h3>";
          } else {
            echo "<h1>Tags</h1>";
          }
          ?>
        </div>
      </div>

      <?php
      if ($connect) {
        if (isset($_POST['slot'])) {
          $query = "SELECT * from tag where  fk_serial_number = '" . $_POST['slot'] . "' ORDER BY date_active DESC;";
        } else {
          $query = "SELECT * from tag ORDER BY date_active ASC;";
        }

        if ($result = $connect->query($query)) {
          if ($result->num_rows > 0) { ?>
            <div class="row mt-2">
              <div class="col-8">
                <input type="text" id="myInput" onkeyup="searchInTags()" placeholder="Search ...">
              </div>
              <div class="col-4">
                <?php if (isset($_POST['slot'])) {
                  echo "<button class='btn btn-lg btn-primary' onclick=\"add_tag('" . $_POST['slot'] . "')\">Add Tag</button>";
                } ?>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                <table id="myTable" class="w3-table-all w3-small w3-responsive">
                  <tr>
                    <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Tag <i class="fa fa-sort" style="font-size:13px;"></i></th>
                    <?php if (!isset($_POST['slot'])) { ?>
                      <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">Serial Number <i class="fa fa-sort" style="font-size:13px;"></i></th>
                    <?php } ?>
                    <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Date Active<i class="fa fa-sort" style="font-size:13px;"></i></th>
                    <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(4)')" style="cursor:pointer;text-align: center">Removed <i class="fa fa-sort" style="font-size:13px;"></i></th>
                    <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(5)')" style="cursor:pointer;text-align: center">Compliance <i class="fa fa-sort" style="font-size:13px;"></i></th>
                    <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(6)')" style="cursor:pointer;text-align: center">Status <i class="fa fa-sort" style="font-size:13px;"></i></th>
                    <th class="w3-dark-grey w3-hover-black" style="text-align: center">Action</th>
                  </tr>
                  <?php
                  while ($row = $result->fetch_assoc()) {

                    $output = "<tr class=\"item\"><td>" . $row["tag_number"] . "</td>";
                    $output =  (isset($_POST['slot'])) ? $output  : $output . "<td>" . $row["fk_serial_number"] . "</td>";
                    $output = $output . "<td>" . $row["date_active"] . "</td><td style='text-align: center'>" . ($row["removed"] ? "Removed" : "Attached") . "</td><td style='text-align: center'>";
                    $output = $output . ($row["broken"] ? "<h6><span class='badge bg-danger '>VIOLATION</span></h6>" : "<h6><span class='ps-3  pe-3 badge bg-success '>OK</span></h6>") . "</td><td style='text-align: center'>" . ($row["active"] ? "<h6><span class='ps-3  pe-3 badge bg-success'>ACTIVE</span></h6>" : "");
                    $output = $output . "<td style='text-align: center' ><i onclick=\"edit_tag('" . $row["id"] . "')\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Change Compliance\" class='fa-thin fa-2x fa-user-police-tie me-2'></i>";
                    echo  $output . "<i onclick=\"remove_tag('" . $row["id"] . "')\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".  ($row["removed"] ? "Attach" : "Remove") ." Tag\" class='fa-thin fa-2x fa-square-". ($row["removed"] ? "plus" : "minus") . " ms-2'></i></td></tr>";
                  }
                } else { ?>
                  <div class="row pt-5 pb-5">
                    <div class="col-12 text-center">
                      <h1> <span class="badge bg-warning text-dark"> No Tags Found </span>
                        <h1>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 text-center">
                      <?php
                      if (isset($_POST['slot'])) { ?>
                        <button class='btn btn-lg btn-primary' onclick="add_tag('<?php echo (isset($_POST['slot']) ? $_POST['slot'] : '') ?>')">Add Tag</button>
                      <?php } else { ?>
                        <button class='btn btn-lg btn-primary' onclick="window.location.assign('slot.php');">Select a Slot Machine</button>
                      <?php } ?>
                    </div>
                  </div>

            <?php }
              }
            }
            ?>
                </table>
              </div>
            </div>
    </div>
  </main>


  <div class="div-body">
    <style media="screen">
      <?php
      if (isset($_POST['add_tag'])) {
        echo "
          .modal-div {
            display: block;
          }";
      };
      ?>
    </style>
    <?php
    ?>
  </div>

  <div class="footer mt-auto">
    <?php
    include 'footer.php';
    ?>
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

    function edit_tag(id) {
      bool = 1;
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "PHP/addTag.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "edit_tag");
      hiddenField.setAttribute("value", id);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }

    function remove_tag(id) {
      bool = 1;
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "PHP/addTag.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "remove_tag");
      hiddenField.setAttribute("value", id);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }

    function add_tag(serial_number) {
      bool = 1;
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "tag.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "slot");
      hiddenField.setAttribute("value", serial_number);
      form.appendChild(hiddenField);
      var hiddenField2 = document.createElement("input");
      hiddenField2.setAttribute("type", "hidden");
      hiddenField2.setAttribute("name", "add_tag");
      hiddenField2.setAttribute("value", serial_number);
      form.appendChild(hiddenField2);
      document.body.appendChild(form);
      form.submit();
    }

    var bool = 0;
    $(document).ready(function() {


    });
  </script>


  </div>
  <div id="id_add_tag" class="modal-div">
    <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
    <form class="modal-div-content" action="PHP/addTag.php" method="POST">
      <div class="container">
        <h1><b>Add Tag</b></h1>
        <hr>
        <input class="fs-1" type="hidden" value="<?php echo (isset($_POST['slot'])) ? $_POST['slot'] : '' ?>" name="serial_number" placeholder="Scan Tag ... ">
        <input class="fs-1" type="text" value="" name="tag_number" placeholder="Scan Tag ... ">
        <div class="clearfix">
          <button type="submit" class="m-3 savebtn btn btn-lg btn-success">Save</button>
          <button type="button" onclick="closeAdd()" class="m-3 cancelbtn btn btn-lg btn-warning">Cancel</button>
        </div>
      </div>
    </form>
  </div>

</body>

</html>