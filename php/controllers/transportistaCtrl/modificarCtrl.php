<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $transportista_id = intval($_POST['transportista_id']);
  $nombre = htmlspecialchars($_POST['nombre']);
  $telefono = htmlspecialchars($_POST['telefono']);
  $email = htmlspecialchars($_POST['email']);

  $sql = "UPDATE transportista SET nombre = ?, telefono = ?, email = ? WHERE transportista_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssi", $nombre, $telefono, $email, $transportista_id);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-transportistas.php");
      exit();
    } else {
      echo "Error al modificar el transportista: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
