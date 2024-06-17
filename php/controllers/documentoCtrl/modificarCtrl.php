<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $idDocumento = intval($_POST['id']);
  $titulo = htmlspecialchars($_POST['titulo']);
  $contenido = htmlspecialchars($_POST['contenido']);

  $sql = "UPDATE documento SET titulo = ?, contenido = ? WHERE documento_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssi", $titulo, $contenido, $idDocumento);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-documentos.php?message=Documento modificado con éxito");
      exit();
    } else {
      echo "Error al modificar el documento: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
?>
