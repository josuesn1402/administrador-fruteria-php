<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $tipo = htmlspecialchars($_POST['tipo_documento']);
  $numero = htmlspecialchars($_POST['numero']);
  $fecha_emision = htmlspecialchars($_POST['fecha_emision']);
  $monto = htmlspecialchars($_POST['monto']);

  $sql = "INSERT INTO documento (tipo_documento, numero, fecha_emision, monto) VALUES (?, ?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssd", $tipo, $numero, $fecha_emision, $monto);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-documentos.php");
      exit();
    } else {
      echo "Error al registrar el documento: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
