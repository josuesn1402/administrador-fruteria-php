<?php
include '../../config/connection.php';

if (isset($_GET['id'])) {
  $idEntrega = intval($_GET['id']);
  $sql = "DELETE FROM entrega WHERE entrega_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $idEntrega);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-entregas.php?message=Entrega eliminada con éxito");
      exit();
    } else {
      echo "Error al eliminar la entrega: " . $stmt->error;
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
