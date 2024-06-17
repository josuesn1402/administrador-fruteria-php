<?php
include '../../config/connection.php';

if (isset($_GET['id'])) {
  $idPedido = intval($_GET['id']);
  $sql = "DELETE FROM pedido WHERE pedido_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $idPedido);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-pedidos.php?message=Pedido eliminado con éxito");
      exit();
    } else {
      echo "Error al eliminar el pedido: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
} else {
  echo "ID no proporcionado";
}
