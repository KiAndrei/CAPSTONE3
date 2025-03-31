<?php
$host = "localhost";
$username = "root";
$password = "";  // Empty string since no password is set
$database = "lawfirm";

$conn = mysqli_connect("localhost", "root", "", "lawfirm");


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
