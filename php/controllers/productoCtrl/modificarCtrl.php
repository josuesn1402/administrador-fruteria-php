<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = htmlspecialchars($_POST['id']);
  $nombre = htmlspecialchars($_POST['nombre']);
  $tipo = htmlspecialchars($_POST['tipo']);
  $cantidad = intval($_POST['cantidad']);
  $precio = floatval($_POST['precio']);

  $sql = "UPDATE producto SET nombre=?, tipo=?, cantidad=?, precio=? WHERE producto_id=?";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssidi", $nombre, $tipo, $cantidad, $precio, $id);

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