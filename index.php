<!DOCTYPE html>
<html>
  <head>
    <title>Home</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="favicon/favicon.png">

  </head>
  <body>
    <div class="header">
      <?php
        include 'header.php';
      ?>
    </div>
    <div class="div-body">

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
  </script>
</html>
