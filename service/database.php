<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "bukutamu";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    echo "Database eror";
    die("error");
}
?>