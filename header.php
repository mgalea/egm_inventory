<html lang="en" dir="ltr">


<body class="d-flex flex-column h-100">
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
  <header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fs-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img class= "brand-img" src="images/lslga.png" alt="" >
        <img class= "name-img" src="images/svg/title.svg" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
          <li class="nav-item">
            <a class="nav-link active  ms-2 " aria-current="page" href="#" onclick="window.location.assign('index.php');" >Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-2 " href="#" onclick="window.location.assign('operator.php');">Operators</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-2" href="#" onclick="window.location.assign('establishment.php');">Locations</h1></a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-2" href="#" onclick="window.location.assign('slot.php');">Slots</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link ms-2 " href="#"  onclick="window.location.assign('tag.php');">Tags</a>
          </li>
          <?php if (isset($type_user) && $type_user == "1") { ?>
            <a class="nav-link ms-2 " onclick="window.location.assign('modify.php');">Settings</a>
          <?php } ?>

        </ul>
        <li class="nav-item">
          <button class="mt-2 btn btn-warning float-end" onclick="window.location.assign('PHP/logout.php')"> Log Out</h1> </button>
          <ul>

      </div>
    </div>
  </nav>
  </header>
  <div class="header-spacer"></div>
  </div>

</body>

</html>