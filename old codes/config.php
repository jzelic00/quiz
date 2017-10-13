<?php

//spoj na localhost
$connect = mysqli_connect("localhost", "root", "", "quiz") or die ("mysql error");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
} 

?>