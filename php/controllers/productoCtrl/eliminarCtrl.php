<?php
include '../../config/connection.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // Luego, eliminar el registro de la base de datos
  $sql = "DELETE FROM producto WHERE producto_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-productos.php");
    } else {
      echo "Error: " . $stmt->error;
    }

    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
} else {
  echo "ID no proporcionado";
}

$conn->close();
