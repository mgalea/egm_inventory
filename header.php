<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <?php
      session_start();

      include 'PHP/connection.php';
      $connect = connectDB();

      $username="";
      $type_user="";

      if(isset($_SESSION['user']) && $_SESSION['user']!=""){
            $username=$_SESSION['user'];
      }
      else{
        header("Location: login.php");
      }
      if(isset($_SESSION['user_type']) && $_SESSION['user_type']!=""){
            $type_user=$_SESSION['user_type'];
      }
      else{
        header("Location: login.php");
      }

    ?>
    <div class="header-100">
      <div class="header-25">
        <a href="index.php"><img class="header-img" src="images/logo.png" alt="Random System"></a>
      </div>
      <div class="header-75">
        <div class="header-group">
          <button type="button" class="btn header-logout" onclick="window.location.assign('PHP/logout.php');">Logout</button>
          <?php if(isset($type_user) && $type_user=="1"){ ?>
            <button type="button" class="btn header-modify" onclick="window.location.assign('modify.php');">Administrator</button>
          <?php } ?>
          <label class="header-user">Hi, <?php echo $username; ?></label>
        </div>
        <div class="btn-group">
          <button type="button" class="btn header-button" onclick="window.location.assign('operator.php');">Operator</button>
          <button type="button" class="btn header-button" onclick="window.location.assign('establishment.php');">Establishment</button>
          <button type="button" class="btn header-button" onclick="window.location.assign('slot.php');">Slot</button>
          <button type="button" class="btn header-button" onclick="window.location.assign('device.php');">Device</button>
        </div>
      </div>
    </div>
  </body>
</html>
