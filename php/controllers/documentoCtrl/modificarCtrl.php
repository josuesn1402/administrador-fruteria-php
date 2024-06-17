<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $idDocumento = intval($_POST['id']);
  $tipo = htmlspecialchars($_POST['tipo_documento']);
  $numero = htmlspecialchars($_POST['numero']);
  $fecha_emision = htmlspecialchars($_POST['fecha_emision']);
  $monto = htmlspecialchars($_POST['monto']);

  $sql = "UPDATE documento SET tipo_documento = ?, numero = ?, fecha_emision = ?, monto = ? WHERE documento_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssdi", $tipo, $numero, $fecha_emision, $monto, $idDocumento);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-documentos.php");
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
