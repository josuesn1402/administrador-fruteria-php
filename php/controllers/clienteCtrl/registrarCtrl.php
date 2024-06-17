<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = htmlspecialchars($_POST['nombre']);
  $direccion = htmlspecialchars($_POST['direccion']);
  $telefono = htmlspecialchars($_POST['telefono']);
  $email = htmlspecialchars($_POST['email']);
  $tipo = htmlspecialchars($_POST['tipo']);

  $sql = "INSERT INTO cliente (nombre, direccion, telefono, email, tipo) VALUES (?, ?, ?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssss", $nombre, $direccion, $telefono, $email, $tipo);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-clientes.php");
      exit();
    } else {
      echo "Error al registrar el cliente: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
