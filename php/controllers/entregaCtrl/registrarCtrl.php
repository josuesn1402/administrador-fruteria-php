<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fecha = htmlspecialchars($_POST['fecha']);
  $descripcion = htmlspecialchars($_POST['descripcion']);
  $destino = htmlspecialchars($_POST['destino']);
  $estado = htmlspecialchars($_POST['estado']);

  $sql = "INSERT INTO entrega (fecha, descripcion, destino, estado) VALUES (?, ?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssss", $fecha, $descripcion, $destino, $estado);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-entregas.php?message=Entrega registrada con éxito");
      exit();
    } else {
      echo "Error al registrar la entrega: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
