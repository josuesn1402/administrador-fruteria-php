<?php
include '../../config/connection.php';

if (isset($_GET['id'])) {
  $transportista_id = intval($_GET['id']);
  $sql = "DELETE FROM transportista WHERE transportista_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $transportista_id);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-transportistas.php");
      exit();
    } else {
      echo "Error al eliminar el transportista: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
} else {
  echo "ID no proporcionado";
}
