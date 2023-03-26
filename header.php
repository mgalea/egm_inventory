<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Slots IMS</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
  <?php
  session_start();

  include 'PHP/connection.php';
  $connect = connectDB();

  $username = "";
  $type_user = "";

  if (isset($_SESSION['user']) && $_SESSION['user'] != "") {
    $username = $_SESSION['user'];
  } else {
    header("Location: login.php");
  }
  if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != "") {
    $type_user = $_SESSION['user_type'];
  } else {
    header("Location: login.php");
  }

  ?>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fs-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="images/lslga.png" alt="" width="100">
        <img src="images/svg/title.svg" alt="" width="200">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active font-display ms-2" aria-current="page" href="#" onclick="window.location.assign('index.php');"><span class="font-display">Home</a>
          </li>
          <li class="nav-item">
            <a class="font-display nav-link ms-2 " href="#"><span class="font-display" onclick="window.location.assign('operator.php');">Operators</a>
          </li>
          <li class="nav-item">
            <a class="font-display nav-link ms-2" href="#"><span class="font-display" onclick="window.location.assign('establishment.php');">Establishments</a>
          </li>
          <li class="nav-item">
            <a class="font-display nav-link ms-2" href="#"><span class="font-display" onclick="window.location.assign('slot.php');">Slots</a>
          </li>
          <li class="nav-item ">
            <a class="font-display nav-link ms-2 " href="#"><span class="font-display" onclick="window.location.assign('device.php');">Tags</a>
          </li>
          <?php if (isset($type_user) && $type_user == "1") { ?>
            <a class="font-display nav-link ms-2 " onclick="window.location.assign('modify.php');">Settings</a>
          <?php } ?>

        </ul>
        <li class="nav-item">
          <button class="ms-2 mt-3 btn btn-warning " onclick="window.location.assign('PHP/logout.php')"> <span class="font-display">Log Out</h1> </button>
          <ul>

      </div>
    </div>
  </nav>

  <div class="header-spacer"></div>
  </div>

</body>

</html>