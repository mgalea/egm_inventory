<!DOCTYPE html>
<html>

<head>
  <title>Slot Images</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://kit.fontawesome.com/8be26e49e1.js" crossorigin="anonymous"></script>
  <link rel="icon" href="favicon/favicon.ico">

  <script src="https://www.w3schools.com/lib/w3.js"></script>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/camera.css">

</head>

<body>

  <div class="header">
    <?php
    include 'header.php';
    ?>
  </div>
  <main class="flex-shrink-0">
    <div class="container-fluid">
      <div class="div-body">

        <?php
        $slot = "";
        if (isset($_POST["slot"]) || isset($_GET["slot"])) {
          $slot = (isset($_POST["slot"])) ? $_POST["slot"] : $_GET["slot"];
        } else {
          header("location: slot.php");
        } ?>

        <div id="id_camera" class="modal-div-info">
          <style>

          </style>
          <span onclick="closeFunction()" class="close_add" title="Close">&times;</span>
          <div class="modal-div-content-camera">
            <div class="container-camera">
              <div class="clearfix">
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
      </div>
      <h1>Slot Images</h1>
      <div class="row mt-3 mb-5">

        <?php
        $query = "SELECT * FROM slot_machines, manufacturer,slot_model, operator WHERE serial_number = \"" . $slot . "\" AND fk_model=id_model AND fk_id_manufacturer=id_manufacturer AND fk_license_number=license_number;";
        if ($result = $connect->query($query)) {
          if ($row = $result->fetch_assoc()) {
            echo "<div class='col-sm-12 col-md-4 col-xl-3 mt-2'><table class='w3-table-all ' width='100%'>";
            echo "<tr><td><b>Serial Number:</b></td><td>" . $slot . "</td></tr>";
            echo "<td><b>Inventory Number:</b></td><td>" . $row["reg_number"] . "</td></tr>";
            echo "</table></div>";
            echo "<div class='col-sm-12 col-md-4 col-xl-3 mt-2'><table class='w3-table-all '>";
            echo "<tr><td><b>Serial Number:</b></td><td>" . $slot . "</td></tr>";
            echo "<td><b>Model:</b></td><td>" . $row["name_model"] . "</td></tr>";
            echo "</table></div>";
            echo "<div class='col-sm-12 col-md-4 col-xl-3 mt-2'><table class='w3-table-all '>";
            echo "<td><b>Manufacturer:</b></td><td>" . $row["name_manufacturer"] . "</td></tr>";
            echo "<td><b>Operator:</b></td><td>" . $row["company_name"] . "</td></tr>";
            echo "</table></div>";
          }
        }
        ?>
      </div>
      <div class="row text-center">
        <div class="col-sm-1 col-4-md"></div>
        <div class="col-sm-10 col-4-md">
          <form action="PHP/uploadImages.php" method="POST" enctype="multipart/form-data">
            <input  type="hidden" name="slot" value="<?php echo $slot; ?>">

            <label for="fileToUpload " class="form-label float-start">Choose image to uplaod (JPG or PNG)</label>

            <input class="form-control form-control-lg float-start" type="file" name="fileToUpload[]" id="fileToUpload" accept="image/*" multiple>

            <input class="btn btn-lg btn-primary mt-2 float-end" type="submit" value="Upload Image" name="submit">

          </form>
        </div>
        <div class="col-sm-1 col-4-md"></div>
      </div>
      <div class="row text-center">
        <div class="col-sm-1 col-4-md"></div>
        <div class="col-sm-10 col-4-md">
          <button class="mt-5 mb-5 btn btn-lg btn-warning" onclick="init()" type="button" name="button">Take from Camera</button>
        </div>
      </div>


      <?php
      $query = "SELECT * FROM photos WHERE fk_serial_number = \"" . $slot . "\";";
      if ($result = $connect->query($query)) {
        if ($result->num_rows > 0) { ?>
          <form id="delForm" action="PHP/deleteImage.php" method="post">
            <div class="row text-center mt-4">
              <div class="col-12">
                <input type="hidden" name="slot" value="<?php echo $slot ?>">

                <?php while ($row = $result->fetch_assoc()) {

                  echo "<div class=\"container-img\"><input type=\"checkbox\" name=\"images[]\" value=" . $row['id'] . " class=\"form-check-input\"><img width='100%' align=\"top\" class=\"col-25-images\" src=\"uploads/" . $row['image'] . "\"></div>";
                } ?>
              </div>
              <div class="row text-center mt-4">
                <div class="col-12 text-center">
                  <button class="btn btn-lg btn-success mt-5 mb-5" onclick="deleteImages()" type="button" name="button">Delete Images</button>
                </div>
              </div>
            </div>
          </form>
      <?php }
      }
      ?>


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
  navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

  var video;
  var webcamStream;
  var canvas, ctx;


  function closeFunction() {
    document.getElementById('id_camera').style.display = 'none';
  }

  function hasGetUserMedia() {
    return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
      navigator.mozGetUserMedia || navigator.msGetUserMedia);
  }

  function openCam() {
    let All_mediaDevices = navigator.mediaDevices
    if (!All_mediaDevices || !All_mediaDevices.getUserMedia) {
      console.log("getUserMedia() not supported.");
      return;
    }
    All_mediaDevices.getUserMedia({
        audio: true,
        video: true
      })
      .then(function(vidStream) {

        video = document.getElementById('video');

        if ("srcObject" in video) {
          video.srcObject = vidStream;
        } else {
          video.src = window.URL.createObjectURL(vidStream);
        }
        video.onloadedmetadata = function(e) {
          document.getElementById('id_camera').style.display = 'block';
          video.play();
        };
      })
      .catch(function(e) {
        console.log(e.name + ": " + e.message);
      });
  }


  function startWebcam() {
    if (navigator.getUserMedia) {
      navigator.getUserMedia({
          video: true,
          audio: false
        },
        function(localMediaStream) {
          video = document.querySelector('video');
          video.src = window.URL.createObjectURL(localMediaStream);
          webcamStream = localMediaStream;
        },
        function(err) {
          console.log("The following error occured: " + err);
        }
      );
    } else {
      console.log("getUserMedia not supported");
    }
  }

  function stopWebcam() {
    webcamStream.getVideoTracks()[0].stop();
  }


  function init() {
    canvas = document.getElementById("myCanvas");
    canvas.width = 2560;
    canvas.height = 1920;
    ctx = canvas.getContext('2d');
    openCam();
  }

  function snapshot() {
    let image = '';

    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    canvas.style.display = 'block';
    video.style.display = 'none';
    document.getElementById("take-snapshot").style.display = 'none';
    document.getElementById("save-snapshot").style.display = 'block';
    document.getElementById("cancel-snapshot").style.display = 'block';
  }

  function cancelSnapshot() {
    canvas.style.display = 'none';
    video.style.display = 'block';
    document.getElementById("take-snapshot").style.display = 'block';
    document.getElementById("save-snapshot").style.display = 'none';
    document.getElementById("cancel-snapshot").style.display = 'none';
  }

  function takeCamera() {
    document.getElementById('id_camera').style.display = 'block';
    init();
  }

  function deleteImages() {
    document.getElementById("delForm").submit();
  }

  function save() {
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

  function refreshFunction(slot_val) {
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