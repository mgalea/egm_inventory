<?php

session_start();

$_SESSION['user'] = "";
$_SESSION['user_type'] = "";

header("Location: ../index.php");

exit;

?>
