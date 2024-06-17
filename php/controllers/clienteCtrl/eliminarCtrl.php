<?php
include '../../config/connection.php';

if (isset($_GET['id'])) {
  $idCliente = intval($_GET['id']);
  $sql = "DELETE FROM cliente WHERE cliente_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $idCliente);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-clientes.php");
      exit();
    } else {
      echo "Error al eliminar el cliente: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
} else {
  echo "ID no proporcionado";
}
