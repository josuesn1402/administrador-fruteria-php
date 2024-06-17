<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $titulo = htmlspecialchars($_POST['titulo']);
  $contenido = htmlspecialchars($_POST['contenido']);

  $sql = "INSERT INTO documento (titulo, contenido) VALUES (?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $titulo, $contenido);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-documentos.php?message=Documento registrado con éxito");
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
?>
