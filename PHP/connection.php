<?php
function connectDB()
{
  $servername = "localhost";
  $username = "root";
  $password = "4pXePY8LRcGA";
  $dbname = "dbmalta";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  return $conn;
}

?>
