<?php
$servername = "localhost";
$username = "root";
$password = "root2024";
$database = "la_frutita";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}
?>