<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/camera.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="icon" href="favicon/favicon.ico">

  </head>
  <body>

    <div class="header">
      <?php
        include 'header.php';
      ?>
    </div>

    <div class="div-body">

      <?php
      $slot = "";
      if(isset($_POST["slot"])){
        $slot=$_POST["slot"];
      }
      else{
        header("location: slot.php");
      }?>

      <div id="id_camera" class="modal-div-camera">
        <span onclick="closeFunction()" class="close_add" title="Close">&times;</span>
        <div class="modal-div-content-camera">
          <div class="container-camera">
            <div class="col-100-camera">
              <video onclick="snapshot(this);" id="video" autoplay></video>
              <canvas style="display:none;" id="myCanvas"></canvas>
            </div>
            <div class="col-100-camera">
              <button id="take-snapshot" onclick="snapshot();">Take Snapshot</button>
              <div class="col-50-camera-padding">
                <button id="cancel-snapshot" style="display:none;" onclick="cancelSnapshot();">Cancel</button>
              </div>
              <div class="col-50-camera-padding">
                <button id="save-snapshot" style="display:none;" onclick="save();">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="id_add_seal" class="modal-div-seal">
        <span onclick="closeAddSeal()" class="close_add" title="Close">&times;</span>
        <div class="modal-div-content-seal">
          <div class="container-seal">
            <h1>Add Seal</h1>
            <hr>
            <label><b>Seal Number</b></label>
            <input id="seal_number" class="input-add" type="text" name="seal_number">
            <label><b>Date Seal</b></label>
            <input id="date_seal" class="input-add" type="date" name="date_seal">
            <div class="clearfix">
              <button type="button" onclick="closeAddSeal()" class="cancelbtn button">Cancel</button>
              <button type="button" onclick="addSeal()" class="button savebtn">Save</button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-100">
        <div class="col-75">
          <h1>Seal</h1>
        </div>
        <div class="col-25">
          <button class="button" onclick="document.getElementById('id_add_seal').style.display='block'">Add Seal</button>
        </div>
      </div>

      <div class="col-100">
        <table id="myTable" class="w3-table-all">
          <tr>
            <th class="w3-dark-grey w3-hover-black">Seal Number</th>
            <th class="w3-dark-grey w3-hover-black">Date Seal</th>
          </tr>
          <?php
          if($connect){
            $query= "SELECT * from seal where fk_serial_number = \"".$slot."\" ORDER BY date_seal DESC;";
            if($result = $connect->query($query)){
              if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class=\"item\"><td>";
                    if($row["broken"]=="1"){
                      echo "<del>";
                    }
                    echo $row["seal_number"];
                    if($row["broken"]=="1"){
                      echo "</del>";
                    }
                    echo "</td><td>";
                    if($row["broken"]=="1"){
                      echo "<del>";
                    }
                    echo $row["date_seal"];
                    if($row["broken"]=="1"){
                      echo "</del>";
                    }
                    echo "</td></tr>";
                }
              }
            }
          }
          ?>
        </table>
      </div>

      <div class="col-100">
        <h1>Images</h1>
      </div>
      <div class="col-100-camera">
        <div class="col-50-camera">
          <form action="PHP/uploadImages.php" method="POST" enctype="multipart/form-data">
            <input style="display:none;" type="text" name="slot" value="<?php echo $slot; ?>">
            <div class="col-50-camera">
              <input class="button-camera" type="file" name="fileToUpload[]" id="fileToUpload" accept="image/*" multiple>
            </div>
            <div class="col-50-camera">
              <input class="button-camera" type="submit" value="Upload Image" name="submit">
            </div>
          </form>
        </div>
        <div class="col-25-camera">
          <button class="button-camera" onclick="takeCamera()" type="button" name="button">Take from Camera</button>
        </div>
        <div class="col-25-camera">
          <button class="button-camera" onclick="deleteImages()" type="button" name="button">Delete Images</button>
        </div>
      </div>
      <div class="col-100-camera-padding">
        <form id="delForm" action="PHP/deleteImage.php" method="post">
          <?php
          $query= "SELECT * FROM photos WHERE fk_serial_number = \"".$slot."\";";
          if($result = $connect->query($query)){
              while($row = $result->fetch_assoc()){
                echo "<input type=\"checkbox\" name=\"images[]\" value=".$row['id']."><img class=\"col-25-images\" src=\"uploads/".$row['image']."\">";
              }
          }
          ?>
        </form>
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
    navigator.getUserMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

    var video;
    var webcamStream;

    function closeFunction(){
      stopWebcam();
      document.getElementById('id_camera').style.display='none';
    }

    function closeAddSeal(){
      document.getElementById('id_add_seal').style.display='none';
    }

    function startWebcam(){
      if (navigator.getUserMedia){
        navigator.getUserMedia(
          {
            video: true,
            audio: false
          },
          function(localMediaStream){
            video = document.querySelector('video');
            video.src = window.URL.createObjectURL(localMediaStream);
            webcamStream = localMediaStream;
          },
          function(err){
            console.log("The following error occured: " + err);
          }
        );
      }
      else{
        console.log("getUserMedia not supported");
      }
    }

    function stopWebcam(){
      webcamStream.getVideoTracks()[0].stop();
    }

    var canvas, ctx;

    function init(){
      canvas = document.getElementById("myCanvas");
      ctx = canvas.getContext('2d');
      startWebcam();
    }

    function snapshot() {
      ctx.drawImage(video, 0,0, canvas.width, canvas.height);
      canvas.style.display = 'block';
      video.style.display = 'none';
      document.getElementById("take-snapshot").style.display = 'none';
      document.getElementById("save-snapshot").style.display = 'block';
      document.getElementById("cancel-snapshot").style.display = 'block';
    }

    function cancelSnapshot(){
      canvas.style.display = 'none';
      video.style.display = 'block';
      document.getElementById("take-snapshot").style.display = 'block';
      document.getElementById("save-snapshot").style.display = 'none';
      document.getElementById("cancel-snapshot").style.display = 'none';
    }

    function takeCamera() {
      document.getElementById('id_camera').style.display='block';
      init();
    }

    function deleteImages() {
      document.getElementById("delForm").submit();
    }

    function save(){
      var canvas = document.getElementById("myCanvas");
      var dataURL = canvas.toDataURL("image/png");

      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "PHP/saveCamera.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "image");
      hiddenField.setAttribute("value", dataURL);
      var hiddenField2 = document.createElement("input");
      hiddenField2.setAttribute("type", "hidden");
      hiddenField2.setAttribute("name", "slot");
      hiddenField2.setAttribute("value", "<?php echo $slot; ?>");
      form.appendChild(hiddenField);
      form.appendChild(hiddenField2);
      document.body.appendChild(form);
      form.submit();
    }

    function addSeal(){
      var seal_number_val = $("#seal_number").val();
      var date_seal_val = $("#date_seal").val();
      var slot_val = "<?php echo $slot; ?>";
      $.post('PHP/addSeal.php', { slot: slot_val, seal_number: seal_number_val, date_seal: date_seal_val }, function(data){
        if(data){
          alert(data);
        }
        else{
          refreshFunction(slot_val);
        }
      }).fail(function() {
          alert( "Server error!" );
      });
    }

    function refreshFunction(slot_val){
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "slot_images.php");
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "slot");
      hiddenField.setAttribute("value", slot_val);
      form.appendChild(hiddenField);
      document.body.appendChild(form);
      form.submit();
    }
  </script>
</html>
