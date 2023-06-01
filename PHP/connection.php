<?php
function connectDB()
{

  $servername = "lagos.randomsystems.io";
  $username = "root";
  $password = "4pXePY8LRcGA";
  $dbname = "dblagos";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  return $conn;
}

?>
