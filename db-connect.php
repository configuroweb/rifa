<?php
// DB Host
$host = "localhost";
// DB Username
$uname = "root";
// DB Password
$password = "";
// DB Name
$dbname = "rifa";


$conn = new mysqli($host, $uname, $password, $dbname);
if (!$conn) {
    die("Database Connection Failed.");
}
