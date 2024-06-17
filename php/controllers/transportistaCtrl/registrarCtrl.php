<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = htmlspecialchars($_POST['nombre']);
  $telefono = htmlspecialchars($_POST['telefono']);
  $email = htmlspecialchars($_POST['email']);

  $sql = "INSERT INTO transportista (nombre, telefono, email) VALUES (?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sss", $nombre, $telefono, $email);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-transportistas.php");
      exit();
    } else {
      echo "Error al registrar el transportista: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
