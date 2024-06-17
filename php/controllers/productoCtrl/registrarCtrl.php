<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = htmlspecialchars($_POST['nombre']);
  $tipo = htmlspecialchars($_POST['tipo']);
  $cantidad = intval($_POST['cantidad']);
  $precio = floatval($_POST['precio']);

  $sql = "INSERT INTO producto (nombre, tipo, cantidad, precio) VALUES (?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssid", $nombre, $tipo, $cantidad, $precio);

    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-productos.php");
    } else {
      echo "Error: " . $stmt->error;
    }

    $stmt->close();
  } else {
    echo "Error: " . $conn->error;
  }
}

$conn->close();
