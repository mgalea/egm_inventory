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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="d-flex flex-column vh-100">
    <?php

    if (!isset($_SESSION['user'])) {
        header("Location: PHP/logout.php");
    } else if (isset($_SESSION['user']) && $_SESSION['user'] != "") {
        header("Location: index.php");
    }
    ?>
<main class="flex-shrink-0">
    <div class="container-fluid">
        <img class="pt-5 title" src="images/svg/title.svg" />

        <div class="imgcontainer">
            <img class="brand_img" src="images/lslga.png" alt="Lagos State Lotterie and Gaming Authority">
        </div>

        <form action="PHP/login.php" method="POST">

            <div class="container">
                <div class="d-flex justify-content-center">
                    <div class="login-content">
                        <label class="font-display" for="username">
                            <b>Username</b>
                        </label>
                        <input type="text" placeholder="Enter Username" name="username" required>
                        <label class="pt-2 font-display" for="password">
                            <b>Password</b>
                        </label>
                        <input class="fs-sm-2" type="password" placeholder="Enter Password" name="password" required>
                        <div class="text-center">
                            <button class="mt-3 btn-lg btn-secondary font-display text-center" type="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
    <footer class="footer mt-auto text-center py-2">
    <img class="rsi_img " src="images/rs_AI.svg" alt="Random Systems">
    </footer>

</body>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(window).on("load", function() {
        <?php if (isset($_GET["error"])) { ?>
            alert("<?php echo $_GET["error"]; ?>");
        <?php } ?>
    });
</script>

</html>