<!DOCTYPE html>
<html>

<head>
  <title>Slot Images</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/camera.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <link rel="icon" href="favicon/favicon.png">

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
    if (isset($_POST["slot"])) {
      $slot = $_POST["slot"];
    } else {
      header("location: slot.php");
    } ?>

    <div id="id_camera" class="modal-div-info">
      <style>
        canvas {
          width: 960px;
          height: 540px;
        }
      </style>
      <span onclick="closeFunction()" class="close_add" title="Close">&times;</span>
      <div class="modal-div-content-camera">
        <div class="container-camera">
          <div class="col-100-camera">
            <video onclick="snapshot(this);" id="video" autoplay></video>
            <canvas style="display:none;" id="myCanvas" width="1920px"></canvas>
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
    <main>
      <div class="container-fluid">
        <h1>Images</h1>


        <div class="row text-center">
          <div class="col-sm-1 col-4-md"></div>
          <div class="col-sm-10 col-4-md">
            <form action="PHP/uploadImages.php" method="POST" enctype="multipart/form-data">
              <input style="display:none;" type="text" name="slot" value="<?php echo $slot; ?>">

              <input class="btn btn-outline-secondary" type="file" name="fileToUpload[]" id="fileToUpload" accept="image/*" multiple>

              <input class="btn btn-lg btn-primary" type="submit" value="Upload Image" name="submit">

            </form>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-sm-1 col-4-md"></div>
          <div class="col-sm-10 col-4-md">
            <button class="mt-5 btn btn-lg btn-warning" onclick="init()" type="button" name="button">Take from Camera</button>
          </div>
        </div>
      </div>


      <div class="col-100-camera-padding">
        <form id="delForm" action="PHP/deleteImage.php" method="post">
          <?php
          $query = "SELECT * FROM photos WHERE fk_serial_number = \"" . $slot . "\";";
          if ($result = $connect->query($query)) {
            while ($row = $result->fetch_assoc()) {
              echo "<input type=\"checkbox\" name=\"images[]\" value=" . $row['id'] . "><img width='120px' class=\"col-25-images\" src=\"uploads/" . $row['image'] . "\">";
            }
          }
          ?>
        </form>
      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-lg btn-success" onclick="deleteImages()" type="button" name="button">Delete Images</button>
        </div>
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
  navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

  var video;
  var webcamStream;
  var canvas, ctx;


  function closeFunction() {
    document.getElementById('id_camera').style.display = 'none';
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
    canvas.width = 3840;
    canvas.height = 2160;
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