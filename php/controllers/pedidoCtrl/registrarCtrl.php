<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $codigo_pedido = htmlspecialchars($_POST['codigo_pedido']);
  $fecha_pedido = htmlspecialchars($_POST['fecha_pedido']);
  $cliente_id = intval($_POST['cliente_id']);
  $documento_id = intval($_POST['documento_id']);
  $medio_transporte_id = intval($_POST['medio_transporte_id']);
  $transportista_id = intval($_POST['transportista_id']);
  $fecha_salida = htmlspecialchars($_POST['fecha_salida']);
  $fecha_llegada = htmlspecialchars($_POST['fecha_llegada']);
  $estado = htmlspecialchars($_POST['estado']);

  $sql = "INSERT INTO pedido (codigo_pedido, medio_transporte_id, transportista_id, fecha_pedido, cliente_id, documento_id, fecha_salida, fecha_llegada, estado)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("siisiisss", $codigo_pedido, $medio_transporte_id, $transportista_id, $fecha_pedido, $cliente_id, $documento_id, $fecha_salida, $fecha_llegada, $estado);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-pedidos.php");
      exit();
    } else {
      echo "Error al registrar el pedido: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
