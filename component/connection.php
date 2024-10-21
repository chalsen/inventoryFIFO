<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbas = 'retail_management';

// Create a connection
$connect = new mysqli($host, $user, $pass, $dbas);
// Check the connection
if ($connect->connect_error) {
    die('Connection Error: ' . $connect->connect_error);
}
?>
