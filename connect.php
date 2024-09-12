<?php
// Declare variables
$servername = '127.0.0.1:3307';
$username = 'root';         // tên tài khoảng          
$password = '';               // pass
$dbname = 'db_bookstore';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
// echo 'Connected successfully';
?>