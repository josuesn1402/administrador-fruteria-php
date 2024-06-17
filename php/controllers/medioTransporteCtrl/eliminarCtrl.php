<?php
include '../../config/connection.php';

if (isset($_GET['id'])) {
  $idTransporte = intval($_GET['id']);
  $sql = "DELETE FROM medio_transporte WHERE medio_transporte_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $idTransporte);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-medio-transporte.php");
      exit();
    } else {
      echo "Error al eliminar el medio de transporte: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
} else {
  echo "ID no proporcionado";
}
?>
