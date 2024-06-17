<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $tipo = htmlspecialchars($_POST['tipo']);
  $placa = htmlspecialchars($_POST['placa']);
  $capacidad = intval($_POST['capacidad']);

  $sql = "INSERT INTO medio_transporte (tipo, placa, capacidad) VALUES (?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssi", $tipo, $placa, $capacidad);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-medio-transporte.php");
      exit();
    } else {
      echo "Error al registrar el medio de transporte: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
