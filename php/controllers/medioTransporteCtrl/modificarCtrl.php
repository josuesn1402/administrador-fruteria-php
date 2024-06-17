<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $idTransporte = intval($_POST['id']);
  $tipo = htmlspecialchars($_POST['tipo']);
  $placa = htmlspecialchars($_POST['placa']);
  $capacidad = intval($_POST['capacidad']);

  $sql = "UPDATE medio_transporte SET tipo = ?, placa = ?, capacidad = ? WHERE medio_transporte_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssii", $tipo, $placa, $capacidad, $idTransporte);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-medio-transporte.php");
      exit();
    } else {
      echo "Error al modificar el medio de transporte: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
