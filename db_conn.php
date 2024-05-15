<?php

// Create connection
$conn = mysqli_connect("localhost", "root", "");

// Check connection
if (!$conn) {
  echo "Connection Failed!";
}else{
    echo "Connected successfully";
}

?>


