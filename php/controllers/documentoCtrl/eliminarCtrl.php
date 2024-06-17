<?php
include '../../config/connection.php';

if (isset($_GET['id'])) {
  $idDocumento = intval($_GET['id']);
  $sql = "DELETE FROM documento WHERE documento_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $idDocumento);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-documentos.php?message=Documento eliminado con éxito");
      exit();
    } else {
      echo "Error al eliminar el documento: " . $stmt->error;
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
