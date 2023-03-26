<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="https://www.w3schools.com/w3js/w3js_sort.asp">
    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="favicon/favicon.png">

    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script type="text/javascript">
      function searchInEstablishments() {
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
          td3 = tr[i].getElementsByTagName("td")[2];
          td4 = tr[i].getElementsByTagName("td")[3];
          if (td1) {
            if ((td1.innerHTML.toUpperCase().indexOf(filter) > -1) || (td2.innerHTML.toUpperCase().indexOf(filter) > -1) || (td3.innerHTML.toUpperCase().indexOf(filter) > -1) || (td4.innerHTML.toUpperCase().indexOf(filter) > -1)) {
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
    <div class="div-body">
      <style media="screen">
        <?php
        if(isset($_POST['establishment'])){
          echo "
          .modal-div {
            display: block;
          }";
        };
        if(isset($_POST['establishment_info'])){
          echo "
          .modal-div-info {
            display: block;
          }";
        };
        ?>
      </style>
      <?php
      $official_operator_license="";
      $permit_number="";
      $official_permit_number="";
      $operator_name="";
      $name="";
      $types="";
      $fk_license_number_operator="";
      $strt_nm="";
      $bldg_nm="";
      $twn_nm="";
      $ctry="";
      $latitude="";
      $longitude="";
      $pstl_code_number="";
      $state = "";
      $typeString="";
      $typeNameString="";
      $n_slot_machines="";
      if(isset($_POST['operator'])){
        $query = "SELECT * FROM operator WHERE official_license_number = \"".$_POST['operator']."\";";
        $result = $connect->query($query);
        $row = $result->fetch_assoc();
        $official_operator_license = $row["license_number"];
      }
      if(isset($_POST['establishment'])){
        $permit_number = $_POST['establishment'];
      }
      if(isset($_POST['establishment_info'])){
        $permit_number = $_POST['establishment_info'];
      }
      if($permit_number!=""){
        $query= "SELECT * from establishment, pstl_adr where fk_id_pstl_adr = id_pstl_adr AND permit_number = ".$permit_number.";";
        if($result = $connect->query($query)){
          if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $official_permit_number=$row["official_permit_number"];
            $name=$row["name"];
            $fk_license_number_operator=$row["fk_license_number_operator"];
            $strt_nm=$row["strt_nm"];
            $bldg_nm=$row["bldg_nm"];
            $twn_nm=$row["twn_nm"];
            $ctry=$row["ctry"];
            $latitude=$row["latitude"];
            $longitude=$row["longitude"];
            $pstl_code_number=$row["pstl_code_number"];
            switch ($row["active"]) {
              case "0":
                $state="Cancel";
                break;
              case "1":
                $state="Active";
                break;
              case "2":
                $state="Sospended";
                break;
            }
          }
          $query= "SELECT * FROM establishment_type, type WHERE fk_establishment_type = id_type AND fk_permit_number = ".$permit_number.";";
          if($result = $connect->query($query)){
            if($result->num_rows > 0){
              while($row = $result->fetch_assoc()){
                $typeString = $typeString . $row["fk_establishment_type"] . ",";
                $typeNameString = $typeNameString . $row["namet"] . "</br>";
              }
            }
          }
          $query= "SELECT count(*) AS count_slot_machines FROM slot_machines_establishment WHERE fk_establishment = ".$permit_number.";";
          if($result = $connect->query($query)){
            $row = $result->fetch_assoc();
            $n_slot_machines = $row["count_slot_machines"];
          }
          $query = "SELECT company_name FROM operator, establishment WHERE license_number = ".$fk_license_number_operator.";";
          if($result = $connect->query($query)){
            $row = $result->fetch_assoc();
            $operator_name = $row["company_name"];
          }
        }
      }
      ?>

      <div id="id_info_establishment" class="modal-div-info">
        <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
        <div class="modal-div-content">
          <div class="container">
            <div class="col-50">
              <h2>Info <?php echo $name; ?></h2>
              <label style="margin-top: 20px;">Permit Number: <?php echo $official_permit_number; ?></label></br>
              <label>Name: <?php echo $name; ?></label></br>
              <label>Operator: <?php echo $operator_name; ?></label></br>
              <label>Namber of Machines: <?php echo $n_slot_machines; ?></label></br>
              <label>State: <?php echo $state; ?></label></br>
              <label>Types: <?php echo "</br>".$typeNameString; ?></label></br>
              <h3 style="margin-top: 40px;"><b>Address:</b></h3>
              <label><?php echo $strt_nm; ?>, <?php echo $bldg_nm; ?></label></br>
              <label><?php echo $twn_nm; ?>, <?php echo $ctry; ?></label></br>
              <label><?php echo $pstl_code_number; ?></label></br>
            </div>
            <div class="col-50">
              <div class="col-100-coordinates">
                <label><?php echo $latitude." : ".$longitude; ?></label>
              </div>

              <div id="map-info"></div>

            </div>
          </div>
        </div>
      </div>

      <div id="id_add_establishment" class="modal-div">
        <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
        <form id="formAdd" class="modal-div-content" action="PHP/<?php if(isset($_POST['establishment'])) echo "editEstablishment.php"; else echo "addEstablishment.php"; ?>" method="POST">
          <div class="container">
            <h1><?php if(isset($_POST['establishment'])) echo "Edit Establishment"; else echo "New Establishment"; ?></h1>
            <hr>

            <label><b>Permit Number</b></label>

            <?php if(isset($_POST['establishment'])){ ?>
              <input class="input-add" type="text" name="permit_number" value="<?php echo $permit_number; ?>" style="display:none;">
              <input class="input-add" type="text" value="<?php echo $official_permit_number; ?>" readonly>
            <?php }else{ ?>
              <input class="input-add" type="text" name="permit_number" value="" required>
            <?php } ?>

            <label><b>Operator</b></label>
            <?php
            if(isset($_POST['operator'])){
              $query="SELECT * FROM operator WHERE license_number = ".$official_operator_license.";";
              $result = $connect->query($query);
              $row = $result->fetch_assoc();?>
            <input class="input-add" type="text" value="<?php echo $row['company_name']; ?>" readonly>
            <input id="fk_operator" type="text" name="fk_license_number_operator" value="<?php echo $row['license_number']; ?>">
            <?php }
            else if(isset($_POST['establishment'])){
              $query="SELECT * FROM establishment, operator WHERE license_number = fk_license_number_operator AND permit_number = ".$_POST['establishment'].";";
              $result = $connect->query($query);
              $row = $result->fetch_assoc();?>
            <input class="input-add" type="text" value="<?php echo $row['company_name']; ?>" readonly>
            <input id="fk_operator" type="text" name="fk_license_number_operator" value="<?php echo $row['license_number']; ?>">
            <?php }else{ ?>
            <select class="input-add" name="fk_license_number_operator">
            <?php
              $query = "SELECT * FROM operator;";
              if($result = $connect->query($query)){
                while($row = $result->fetch_assoc()){
                  echo "<option value=\"".$row['license_number']."\">".$row['company_name']."</option>";
                }
              }
              echo "</select>";
            }
            ?>
            <label><b>Name</b></label>
            <input class="input-add" type="text" name="name" value="<?php echo $name; ?>" required>
            <label><b>State</b></label>
            <select class="input-add" name="state">
              <option value="1" <?php if($state=="1") echo "selected"; ?>>Active</option>
              <option value="2" <?php if($state=="2") echo "selected"; ?>>Suspended</option>
              <option value="0" <?php if($state=="0") echo "selected"; ?>>Cancelled</option>
            </select>
            <div class="col-100-add">
              <label><b>Types</b></label>
              <input id="typePHP" name="typePHP" type="text" value="<?php echo $typeString; ?>">
              <div class="col-100-add">

                <div id="div-new" class="col-100-add"></div>

                <div class="col-100-add input-add">
                  <select name="type" id="type" class="input-select-add">
                    <option value=""></option>
                    <?php
                    $query = "SELECT * FROM type;";
                    if($result = $connect->query($query)){
                      while($row = $result->fetch_assoc()){
                        echo "<option value=\"".$row['id_type']."\">".$row['namet']."</option>";
                      }
                    }
                    ?>
                  </select>
                  <button id = "addType" type="button"/>
                </div>
              </div>
            </div>

            <label><b>Address</b></label>
            <div class="col-99">
              <div class="col-50">
                <div>
                  <label>Street Name</label>
                  <input id="strt_nm" class="input-add" type="text" name="strt_nm" value="<?php echo $strt_nm; ?>" required>
                  <label>Building Number</label>
                  <input id="bldgNb" class="input-add" type="text" name="bldgNb" value="<?php echo $bldg_nm; ?>" required>
                  <label>Town Name</label>
                  <input id="twnNm" class="input-add" type="text" name="twnNm" value="<?php echo $twn_nm; ?>" required>
                  <label>Country</label>
                  <input id="ctry" class="input-add" type="text" name="ctry" value="<?php if($ctry!= "") echo $ctry; else echo "Malta"; ?>" required>
                  <label>Postal Code</label>
                  <input id="zip" class="input-add" type="text" name="zip" value="<?php echo $pstl_code_number; ?>" required>
                  <input id="checkbox" type="checkbox" name="coordinates" value="unchecked" <?php if($latitude!="" && $longitude!= "") echo "checked"; ?>> Include Latitude and Longitude<br>
                </div>
              </div>
              <div class="col-50">
                <div class="col-100-add">
                  <div class="coordinates">
                    <label id="latlng"><?php if($latitude!="" && $longitude!= "") echo $latitude." , ".$longitude; ?></label>
                  </div>
                  <input id="refresh" type="button">
                </div>
                <div id="map"></div>
              </div>
            </div>
            <div class="clearfix">
              <button type="button" onclick="closeAdd()" class="cancelbtn button">Cancel</button>
              <button type="submit" class="savebtn button">Save</button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-100">
        <div class="col-75">
        <h1>Establishments</h1>
        </div>
        <div class="col-25">
          <?php if(isset($_POST['operator'])){ ?>
            <button class="button" onclick="showSlots()">Show Slots</button>
          <?php } ?>
        </div>
      </div>
      <div class="col-100">
        <div class="col-75">
          <input type="text" id="myInput" onkeyup="searchInEstablishments()" placeholder="Search ...">
        </div>
        <div class="col-25">
          <button class="button" onclick="document.getElementById('id_add_establishment').style.display='block'">Add Establishment</button>
        </div>
      </div>
      <div class="col-100">
        <table id="myTable" class="w3-table-all">
          <tr>
            <th>Index</th>
            <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Permit Number <i class="fa fa-sort" style="font-size:13px;"></i></th>
            <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">Name <i class="fa fa-sort" style="font-size:13px;"></i></th>
            <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Town <i class="fa fa-sort" style="font-size:13px;"></i></th>
            <?php if(isset($_POST['operator'])){}else{?><th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(4)')" style="cursor:pointer">Operator <i class="fa fa-sort" style="font-size:13px;"></i></th><?php } ?>
            <th class="w3-dark-grey w3-hover-black">Edit</th>
            <th class="w3-dark-grey w3-hover-black">Info</th>
          </tr>
          <?php
          if($connect){
            if(isset($_POST['operator'])){
              $query= "SELECT * from establishment, pstl_adr where fk_id_pstl_adr = id_pstl_adr AND fk_license_number_operator = ".$official_operator_license.";";
              if($result = $connect->query($query)){
                if($result->num_rows > 0){
                  while ($row = $result->fetch_assoc()) {
                      echo "<tr class=\"item\"><td>".$row["permit_number"]."</td><td>".$row["official_permit_number"]."</td><td>".$row["name"]."</td><td>".$row["twn_nm"]."</td><td><img class=\"icon\" onclick=\"edit_establishment(".$row["permit_number"].")\" src=\"images/edit.png\" alt=\"Edit\"></td><td><img class=\"icon\" onclick=\"info_establishment(".$row["permit_number"].")\" src=\"images/info.png\" alt=\"Info\"></td></tr>";
                  }
                }
              }
            }
            else{
              $query= "SELECT * from establishment, pstl_adr, operator where establishment.fk_id_pstl_adr = id_pstl_adr AND license_number = fk_license_number_operator;";
              if($result = $connect->query($query)){
                if($result->num_rows > 0){
                  while ($row = $result->fetch_assoc()) {
                      echo "<tr class=\"item\"><td>".$row["permit_number"]."</td><td>".$row["official_permit_number"]."</td><td>".$row["name"]."</td><td>".$row["twn_nm"]."</td><td>".$row["company_name"]."</td><td onclick=\"edit_establishment(".$row["permit_number"].")\"><img class=\"icon\" src=\"images/edit.png\" alt=\"Edit\"></td><td onclick=\"info_establishment(".$row["permit_number"].")\"><img class=\"icon\" src=\"images/info.png\" alt=\"Info\"></td></tr>";
                  }
                }
              }
            }
          }
          ?>
        </table>
      </div>
    </div>
    <div class="footer">
      <?php
        include 'footer.php';
      ?>
    </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript">

    var markers = [];
    var bool = 0;
    var array =[];
    var container = document.getElementById("div-new");

    $( window ).on( "load", function() {
      <?php if(isset($_GET["error"])){ ?>
        alert("<?php echo $_GET["error"]; ?>");
      <?php } ?>
    });


    var brandString = document.getElementById("typePHP").value;
    brandString = brandString.substring(0, brandString.length - 1);
    var array = brandString.split(",");
    for(var i=0; i<array.length;i++){
      for(var z=0;z<document.getElementById("type").length;z++){
        if(array[i]==document.getElementById("type").options.item(z).value){
          document.getElementById("type").options[z].selected = true;
        }
      }

      if(document.getElementById("type").options[document.getElementById("type").selectedIndex].disabled != true && document.getElementById("type").options.item(document.getElementById("type").selectedIndex).text !=""){

        var input = document.createElement("input");
        input.type = "text";
        input.name = "member";
        input.style.float = "left";
        input.style.width = "calc(100% - 58px)";
        input.style.marginTop = "5px";
        input.style.marginBottom = "5px";
        input.readOnly = true;
        input.value = document.getElementById("type").options.item(document.getElementById("type").selectedIndex).text;
        container.appendChild(input);

        var buttonAdd = document.createElement("button");
        buttonAdd.setAttribute('type', 'button');
        buttonAdd.classList.add("delType");
        buttonAdd.value = document.getElementById("type").selectedIndex;
        buttonAdd.addEventListener('click', function() {
          document.getElementById("type").options[$(this).val()].disabled = false;
          $(this).prev().remove();
          $(this).remove();
          updateType();
        });
        container.appendChild(buttonAdd);
        document.getElementById("type").options[document.getElementById("type").selectedIndex].disabled = true;
      }
    }
    updateType();

    document.getElementById('addType').addEventListener('click', function() {

      if(document.getElementById("type").options[document.getElementById("type").selectedIndex].disabled != true && document.getElementById("type").options.item(document.getElementById("type").selectedIndex).text !=""){
        var input = document.createElement("input");
        input.type = "text";
        input.name = "member";
        input.style.float = "left";
        input.style.width = "calc(100% - 58px)";
        input.style.marginTop = "5px";
        input.style.marginBottom = "5px";
        input.readOnly = true;
        input.value = document.getElementById("type").options.item(document.getElementById("type").selectedIndex).text;
        container.appendChild(input);

        var buttonAdd = document.createElement("button");
        buttonAdd.setAttribute('type', 'button');
        buttonAdd.classList.add("delType");
        buttonAdd.value = document.getElementById("type").selectedIndex;
        buttonAdd.addEventListener('click', function() {
          container.removeChild(buttonAdd);
          container.removeChild(input);
          document.getElementById("type").options[buttonAdd.value].disabled = false;
          updateType();
        });
        container.appendChild(buttonAdd);

        document.getElementById("type").options[document.getElementById("type").selectedIndex].disabled = true;

        updateType();
      }
    });

    function updateType(){
      array = [];
      for(var i = 0; i<document.getElementById("type").length; i++){
        if(document.getElementById("type").options[i].disabled == true){
          array.push(document.getElementById("type").options.item(i).value);
        }
      }
      document.getElementById("typePHP").value = array;
      document.getElementById("type").options[0].selected = true;
    }

    function closeAdd(){
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "establishment.php");
      <?php if(isset($_POST['operator'])){ ?>
      var hiddenField2 = document.createElement("input");
      hiddenField2.setAttribute("type", "hidden");
      hiddenField2.setAttribute("name", "operator");
      hiddenField2.setAttribute("value", "<?php echo $_POST['operator']; ?>");
      form.appendChild(hiddenField2);
      <?php } ?>
      document.body.appendChild(form);
      form.submit();
    }

    function showSlots(){
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "slot.php");
      var hiddenField2 = document.createElement("input");
      hiddenField2.setAttribute("type", "hidden");
      hiddenField2.setAttribute("name", "operator");
      hiddenField2.setAttribute("value", "<?php if(isset($_POST['operator'])) echo $_POST['operator']; ?>");
      form.appendChild(hiddenField2);
      document.body.appendChild(form);
      form.submit();
    }

    function edit_establishment(license){
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "establishment.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "establishment");
      hiddenField.setAttribute("value", license);
      form.appendChild(hiddenField);
      <?php if(isset($_POST['operator'])){ ?>
      var hiddenField2 = document.createElement("input");
      hiddenField2.setAttribute("type", "hidden");
      hiddenField2.setAttribute("name", "operator");
      hiddenField2.setAttribute("value", "<?php echo $_POST['operator']; ?>");
      form.appendChild(hiddenField2);
      <?php } ?>
      document.body.appendChild(form);
      form.submit();
      bool=1;
    }

    function info_establishment(license){
      bool=1;
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "establishment.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "establishment_info");
      hiddenField.setAttribute("value", license);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }

    function initMap() {
      var uluru = {lat: <?php if($latitude!="") echo $latitude; else echo "35.8993352"; ?>, lng: <?php if($longitude!="") echo $longitude; else echo "14.5159417"; ?>};
      var map_info = new google.maps.Map(document.getElementById('map-info'), {zoom: <?php if($latitude!="" && $latitude!="") echo "18"; else echo "2";?>, center: uluru});
      var map = new google.maps.Map(document.getElementById('map'), {zoom: 18, center: uluru});
      <?php if($latitude!="" && $latitude!=""){?>
      var marker = new google.maps.Marker({position: uluru, map: map});
      var marker_info = new google.maps.Marker({position: uluru, map: map_info});
      <?php } ?>
      var geocoder = new google.maps.Geocoder();
      document.getElementById('refresh').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
          deleteMarkers();
        });
      var checkBox = document.getElementById("checkbox");

      checkBox.addEventListener('click', function() {

          if (checkBox.checked == true){
            geocodeAddress(geocoder, map);
            deleteMarkers();
          }

        });
    }
    function geocodeAddress(geocoder, resultsMap) {
      var address = document.getElementById('strt_nm').value+", "+document.getElementById('bldgNb').value+", "+document.getElementById('twnNm').value+", "+document.getElementById('ctry').value+", "+document.getElementById('zip').value;
      geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
          resultsMap.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
            map: resultsMap,
            position: results[0].geometry.location
          });
          markers.push(marker);
          document.getElementById("latlng").innerHTML = results[0].geometry.location.lat()+" , "+results[0].geometry.location.lng();
          document.getElementById("checkbox").value = results[0].geometry.location.lat()+":"+results[0].geometry.location.lng()
        } else {
          alert('Geocode was not successful for the following reason: ' + status);
        }
      });
    }

    function deleteMarkers() {
      for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
      }
      markers = [];
    };

    $("#myTable tr").click(function(){
       $(this).addClass('selected').siblings().removeClass('selected');
        var value=$(this).find('td:nth-child(1)').html();
        if($(this).find('td:first') && bool==0){
          if (typeof value !== 'undefined' && value !== null) {
             var form = document.createElement("form");
             form.setAttribute("method", "post");
             form.setAttribute("action", "slot.php");
             var hiddenField = document.createElement("input");
             hiddenField.setAttribute("type", "hidden");
             hiddenField.setAttribute("name", "establishment");
             hiddenField.setAttribute("value", value);
             form.appendChild(hiddenField);
             document.body.appendChild(form);
             form.submit();
        }
       }
       else if(bool==1){
         bool=0;
       }
    });

  </script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5JqnCRSQBplk02EP7sUdyBEGzXY8XoY&callback=initMap">
  </script>
</html>
