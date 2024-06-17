<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $idEntrega = intval($_POST['id']);
  $fecha = htmlspecialchars($_POST['fecha']);
  $descripcion = htmlspecialchars($_POST['descripcion']);
  $destino = htmlspecialchars($_POST['destino']);
  $estado = htmlspecialchars($_POST['estado']);

  $sql = "UPDATE entrega SET fecha = ?, descripcion = ?, destino = ?, estado = ? WHERE entrega_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssssi", $fecha, $descripcion, $destino, $estado, $idEntrega);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-entregas.php?message=Entrega modificada con éxito");
      exit();
    } else {
      echo "Error al modificar la entrega: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
?>
