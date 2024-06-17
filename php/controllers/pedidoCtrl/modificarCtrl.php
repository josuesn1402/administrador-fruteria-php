<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $pedido_id = intval($_POST['pedido_id']);
  $codigo_pedido = htmlspecialchars($_POST['codigo_pedido']);
  $fecha_pedido = htmlspecialchars($_POST['fecha_pedido']);
  $cliente_id = intval($_POST['cliente_id']);
  $documento_id = intval($_POST['documento_id']);
  $medio_transporte_id = intval($_POST['medio_transporte_id']);
  $transportista_id = intval($_POST['transportista_id']);
  $fecha_salida = htmlspecialchars($_POST['fecha_salida']);
  $fecha_llegada = htmlspecialchars($_POST['fecha_llegada']);
  $estado = htmlspecialchars($_POST['estado']);

  $sql = "UPDATE pedido SET codigo_pedido = ?, medio_transporte_id = ?, transportista_id = ?, fecha_pedido = ?, cliente_id = ?, documento_id = ?, fecha_salida = ?, fecha_llegada = ?, estado = ? WHERE pedido_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("siisiisssi", $codigo_pedido, $medio_transporte_id, $transportista_id, $fecha_pedido, $cliente_id, $documento_id, $fecha_salida, $fecha_llegada, $estado, $pedido_id);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-pedidos.php?message=Pedido modificado con éxito");
      exit();
    } else {
      echo "Error al modificar el pedido: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
