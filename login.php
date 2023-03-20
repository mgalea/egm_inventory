<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/login.css">

        <link rel="icon" href="favicon/favicon.png">

        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    </head>
    <body>
        <?php

if(!isset($_SESSION['user'])){
  header("Location: PHP/logout.php");
}
else if(isset($_SESSION['user']) && $_SESSION['user']!=""){
  header("Location: index.php");
}



?>
        <div class="modal">
            <form action="PHP/login.php" method="POST" class="title">
                <h1><br></h1>
                <img src="images/title.svg"/>
            </form>
            <form class="modal-content animate" action="PHP/login.php" method="POST">
                <div class="imgcontainer">
                    <img src="images/RS_AI.svg" alt="logo" class="logo">
                </div>
                <div class="container">
                    <label for="uname">
                        <b>Username</b>
                    </label>
                    <input type="text" placeholder="Enter Username" name="username" required>
                    <label for="psw">
                        <b>Password</b>
                    </label>
                    <input type="password" placeholder="Enter Password" name="password" required>
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </body>
    <script type="text/javascript">

    $( window ).on( "load", function() {
      <?php if(isset($_GET["error"])){ ?>
        alert("<?php echo $_GET["error"]; ?>");
      <?php } ?>
    });

    </script>
</html>
