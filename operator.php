<!DOCTYPE html>
<html>
  <head>
    <title>Operators</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="favicon/favicon.png">

    <script src="https://www.w3schools.com/lib/w3.js"></script>

    <script type="text/javascript">
      function searchInOperators() {
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
      ?>
    </div>
    <div class="div-body">
      <style media="screen">
        <?php
        if(isset($_POST['operator'])){
          echo "
          .modal-div {
            display: block;
          }";
        };
        if(isset($_POST['operator_info'])){
          echo "
          .modal-div-info {
            display: block;
          }";
        };
        ?>
      </style>
      <?php
      $official_license="";
      $n_machines="";
      $n_a_machines="";
      $brand_name="";
      $license_number="";
      $brandPHP="";
      $license="";
      $name="";
      $telephone="";
      $email="";
      $web="";
      $jurisdiction="";
      $strt="";
      $bldg="";
      $twn="";
      $ctry="";
      $latitude="";
      $longitude="";
      $pstl_code_number="";
      if(isset($_POST['operator'])){
        $license_number = $_POST['operator'];
      }
      if(isset($_POST['operator_info'])){
        $license_number = $_POST['operator_info'];
      }
      if($license_number!=""){
        $query="SELECT * FROM operator, pstl_adr WHERE fk_id_pstl_adr = id_pstl_adr AND license_number = ".$license_number.";";
        if($result = $connect->query($query)){
          $row = $result->fetch_assoc();
          $license=$license_number;
          $official_license=$row['official_license_number'];
          $name=$row['company_name'];
          $telephone=$row['company_telephone'];
          $email=$row['company_email'];
          $web=$row['company_website'];
          $jurisdiction=$row['jurisdiction'];
          $strt=$row['strt_nm'];
          $bldg=$row['bldg_nm'];
          $twn=$row['twn_nm'];
          $ctry=$row['ctry'];
          $latitude=$row['latitude'];
          $longitude=$row['longitude'];
          $pstl_code_number=$row['pstl_code_number'];
          $query="SELECT * FROM brand_operator, brand WHERE fk_operator = ".$license_number." AND fk_brand = id_brand;";
          if($result = $connect->query($query)){
            while($row = $result->fetch_assoc()){
              $brandPHP=$brandPHP.$row['fk_brand'].",";
              $brand_name=$brand_name.$row['name']."<br>";
            }
          }
          $query= "SELECT count(*) AS count_slot_machines from slot_machines where state = 1 AND fk_license_number = $license_number;";
          if($result = $connect->query($query)){
            $row = $result->fetch_assoc();
            $n_a_machines=$row["count_slot_machines"];
          }
          $query= "SELECT count(*) AS count_slot_machines from slot_machines where fk_license_number = $license_number;";
          if($result = $connect->query($query)){
            $row = $result->fetch_assoc();
            $n_machines=$row["count_slot_machines"];
          }
        }
      }
      ?>
      <div id="id_info_operator" class="modal-div-info">
        <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
        <div class="modal-div-content">
          <div class="container">
            <div class="col-50">
              <h2>Info <?php echo $name; ?></h2>
              <label style="margin-top: 20px;">License Number: <?php echo $official_license; ?></label></br>
              <label>Name: <?php echo $name; ?></label></br>
              <label>Namber of Machines: <?php echo $n_machines; ?></label></br>
              <label>Namber of Active Machines: <?php echo $n_a_machines; ?></label></br>
              <label>Telephone: <?php echo $telephone; ?></label></br>
              <label>Email: <?php echo $email; ?></label></br>
              <label>Web Site: <?php echo $web; ?></label></br>
              <label>Jurisdiction: <?php echo $jurisdiction; ?></label></br>
              <label>Brand: <?php echo "</br>".$brand_name; ?></label></br>
              <h3 style="margin-top: 40px;"><b>Address:</b></h3>
              <label><?php echo $strt; ?>, <?php echo $bldg; ?></label></br>
              <label><?php echo $twn; ?>, <?php echo $ctry; ?></label></br>
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

      <div id="id_add_operator" class="modal-div">
        <span onclick="closeAdd()" class="close_add" title="Close">&times;</span>
        <form id="formAdd" class="modal-div-content" action="PHP/<?php if(isset($_POST['operator'])) echo "editOperator.php"; else echo "addOperator.php"; ?>" method="POST">
          <div class="container">
            <h1><?php if(isset($_POST['operator'])) echo "Edit Operator"; else echo "New Operator"; ?></h1>
            <hr>

            <label><b>License Number</b></label>
            <?php if(isset($_POST['operator'])){ ?>
              <input class="input-add" type="text" name="license_number" value="<?php echo $license; ?>" style="display:none;">
              <input class="input-add" type="text" value="<?php echo $official_license; ?>" readonly>
            <?php }else{ ?>
              <input class="input-add" type="text" name="license_number" value="" required>
            <?php } ?>
            <label><b>Name</b></label>
            <input class="input-add" type="text" name="company_name" value="<?php echo $name; ?>" required>
            <label><b>Telephone</b></label>
            <input class="input-add" type="text" name="company_telephone" value="<?php echo $telephone; ?>" required>
            <label><b>Email</b></label>
            <input class="input-add" type="text" name="company_email" value="<?php echo $email; ?>" required>
            <label><b>Web Site</b></label>
            <input class="input-add" type="text" name="company_website" value="<?php echo $web; ?>">
            <label><b>Jurisdiction</b></label>
            <input class="input-add" type="text" name="jurisdiction" value="<?php echo $jurisdiction; ?>" required>
            <div class="col-100-add">
              <label><b>Brand</b></label>
              <input id="brandPHP" name="brandPHP" type="text" value="<?php echo $brandPHP; ?>">
              <div class="col-100-add">

                <div id="div-new" class="col-100-add"></div>

                <div class="col-100-add input-add">
                  <select name="brand" id="brand" class="input-select-add">
                    <option value=""></option>
                    <?php
                    $query = "SELECT * FROM brand;";
                    if($result = $connect->query($query)){
                      while($row = $result->fetch_assoc()){
                        echo "<option value=\"".$row['id_brand']."\">".$row['name']."</option>";
                      }
                    }
                    ?>
                  </select>
                  <button id ="addBrand" type="button"/>
                </div>
              </div>
            </div>
            <label><b>Address</b></label>
            <div class="col-99">
              <div class="col-50">
                <div>
                  <label>Street Name</label>
                  <input id="strt_nm" class="input-add" type="text" name="strt_nm" value="<?php echo $strt; ?>" required>
                  <label>Building Number</label>
                  <input id="bldgNb" class="input-add" type="text" name="bldgNb"  value="<?php echo $bldg; ?>" required>
                  <label>Town Name</label>
                  <input id="twnNm" class="input-add" type="text" name="twnNm"  value="<?php echo $twn; ?>" required>
                  <label>Country</label>
                  <input id="ctry" class="input-add" type="text" name="ctry" value="<?php if($ctry!= "") echo $ctry; else echo "Malta"; ?>" required>
                  <label>Postal Code</label>
                  <input id="zip" class="input-add" type="text" name="zip" value="<?php echo $pstl_code_number; ?>">
                  <input id="checkbox" type="checkbox" name="coordinates" value="<?php if($latitude!="" && $longitude!= "") echo $latitude.":".$longitude; else echo "unchecked" ?>" <?php if($latitude!="" && $longitude!= "") echo "checked"; ?>> Include Latitude and Longitude<br>
                </div>
              </div>
              <div class="col-50">
                <div class="col-100-add">
                  <div class="coordinates">
                    <label id="latlng"><?php if($latitude!="" && $longitude!= "") echo $latitude." , ".$longitude; ?></label>
                  </div>
                  <button id="refresh" type="button">
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
        <h1>Operators</h1>
      </div>
      <div class="col-100">
        <div class="col-75">
          <input type="text" id="myInput" onkeyup="searchInOperators()" placeholder="Search ...">
        </div>
        <div class="col-25">
          <button class="button" onclick="document.getElementById('id_add_operator').style.display='block'">Add Operator</button>
        </div>
      </div>
      <div class="col-100">
        <table id="myTable" class="w3-table-all">
          <tr>
            <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Name <i class="fa fa-sort" style="font-size:13px;"></i></th>
            <th class="w3-dark-grey w3-hover-black" onclick="w3.sortHTML('#myTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">License Number <i class="fa fa-sort" style="font-size:13px;"></i></th>
            <th class="w3-dark-grey w3-hover-black">Edit</th>
            <th class="w3-dark-grey w3-hover-black">Info</th>
          </tr>
          <?php
          if($connect){
            $query= "SELECT * from operator, pstl_adr where fk_id_pstl_adr = id_pstl_adr;";
            if($result = $connect->query($query)){
              if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class=\"item\"><td>".$row["company_name"]."</td><td>".$row["official_license_number"]."</td><td onclick=\"edit_operator(".$row["license_number"].")\"><img class=\"icon\" src=\"images/edit.png\" alt=\"Edit\"></td><td onclick=\"info_operator(".$row["license_number"].")\"><img class=\"icon\" src=\"images/info.png\" alt=\"Info\"></td></tr>";
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

    $( window ).on( "load", function() {
      <?php if(isset($_GET["error"])){ ?>
        alert("<?php echo $_GET["error"]; ?>");
      <?php } ?>
    });


    var markers = [];
    var bool = 0;
    var array =[];
    var container = document.getElementById("div-new");

    var brandString = document.getElementById("brandPHP").value;
    brandString = brandString.substring(0, brandString.length - 1);
    var array = brandString.split(",");
    for(var i=0; i<array.length;i++){
      for(var z=0;z<document.getElementById("brand").length;z++){
        if(array[i]==document.getElementById("brand").options.item(z).value){
          document.getElementById("brand").options[z].selected = true;
        }
      }

      if(document.getElementById("brand").options[document.getElementById("brand").selectedIndex].disabled != true && document.getElementById("brand").options.item(document.getElementById("brand").selectedIndex).text !=""){

        var input = document.createElement("input");
        input.type = "text";
        input.name = "member";
        input.style.float = "left";
        input.style.width = "calc(100% - 58px)";
        input.style.marginTop = "5px";
        input.style.marginBottom = "5px";
        input.readOnly = true;
        input.value = document.getElementById("brand").options.item(document.getElementById("brand").selectedIndex).text;
        container.appendChild(input);

        var buttonAdd = document.createElement("button");
        buttonAdd.setAttribute('type', 'button');
        buttonAdd.classList.add("delBrand");
        buttonAdd.value = document.getElementById("brand").selectedIndex;
        buttonAdd.addEventListener('click', function() {
          document.getElementById("brand").options[$(this).val()].disabled = false;
          $(this).prev().remove();
          $(this).remove();
          updateBrand();
        });
        container.appendChild(buttonAdd);
        document.getElementById("brand").options[document.getElementById("brand").selectedIndex].disabled = true;
      }
    }
    updateBrand();

    document.getElementById('addBrand').addEventListener('click', function() {

      if(document.getElementById("brand").options[document.getElementById("brand").selectedIndex].disabled != true && document.getElementById("brand").options.item(document.getElementById("brand").selectedIndex).text !=""){
        var input = document.createElement("input");
        input.type = "text";
        input.name = "member";
        input.style.float = "left";
        input.style.width = "calc(100% - 58px)";
        input.style.marginTop = "5px";
        input.style.marginBottom = "5px";
        input.readOnly = true;
        input.value = document.getElementById("brand").options.item(document.getElementById("brand").selectedIndex).text;
        container.appendChild(input);

        var buttonAdd = document.createElement("button");
        buttonAdd.setAttribute('type', 'button');
        buttonAdd.classList.add("delBrand");
        buttonAdd.value = document.getElementById("brand").selectedIndex;
        buttonAdd.addEventListener('click', function() {
          container.removeChild(buttonAdd);
          container.removeChild(input);
          document.getElementById("brand").options[buttonAdd.value].disabled = false;
          updateBrand();
        });
        container.appendChild(buttonAdd);

        document.getElementById("brand").options[document.getElementById("brand").selectedIndex].disabled = true;

        updateBrand();
      }
    });

    function updateBrand(){
      array = [];
      for(var i = 0; i<document.getElementById("brand").length; i++){
        if(document.getElementById("brand").options[i].disabled == true){
          array.push(document.getElementById("brand").options.item(i).value);
        }
      }
      document.getElementById("brandPHP").value = array;
      document.getElementById("brand").options[0].selected = true;
    }

    function closeAdd(){
      document.location.href = "operator.php";
    }

    function edit_operator(license){
      bool=1;
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "operator.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "operator");
      hiddenField.setAttribute("value", license);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }

    function info_operator(license){
      bool=1;
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "operator.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "operator_info");
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
        var value=$(this).find('td:nth-child(2)').html();
        if($(this).find('td:first') && bool==0){
          if (typeof value !== 'undefined' && value !== null) {
             var form = document.createElement("form");
             form.setAttribute("method", "post");
             form.setAttribute("action", "establishment.php");
             var hiddenField = document.createElement("input");
             hiddenField.setAttribute("type", "hidden");
             hiddenField.setAttribute("name", "operator");
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
