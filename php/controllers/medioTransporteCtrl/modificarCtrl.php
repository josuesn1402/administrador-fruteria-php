<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $idTransporte = intval($_POST['id']);
  $tipo = htmlspecialchars($_POST['tipo']);
  $capacidad = htmlspecialchars($_POST['capacidad']);

  $sql = "UPDATE medio_transporte SET tipo = ?, capacidad = ? WHERE medio_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssi", $tipo, $capacidad, $idTransporte);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-medio-transporte.php?message=Medio de transporte modificado con éxito");
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
?>
