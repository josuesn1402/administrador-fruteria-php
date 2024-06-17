<?php
include('../../config/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $codigo_pedido = $_POST['codigo_pedido'];
  $fecha_pedido = $_POST['fecha_pedido'];
  $cliente_id = $_POST['cliente_id'];
  $documento_id = $_POST['documento_id'];
  $medio_transporte_id = $_POST['medio_transporte_id'];
  $transportista_id = $_POST['transportista_id'];
  $fecha_salida = $_POST['fecha_salida'];
  $fecha_llegada = $_POST['fecha_llegada'];
  $estado = $_POST['estado'];

  // Insertar el pedido en la base de datos
  $queryInsertPedido = "INSERT INTO pedido (codigo_pedido, fecha_pedido, cliente_id, documento_id, medio_transporte_id, transportista_id, fecha_salida, fecha_llegada, estado) 
                          VALUES ('$codigo_pedido', '$fecha_pedido', '$cliente_id', '$documento_id', '$medio_transporte_id', '$transportista_id', '$fecha_salida', '$fecha_llegada', '$estado')";
  if (mysqli_query($conn, $queryInsertPedido)) {
    // Obtener el último ID de pedido insertado
    $pedido_id = mysqli_insert_id($conn);

    // Insertar los detalles del pedido
    if (isset($_SESSION['productos']) && !empty($_SESSION['productos'])) {
      foreach ($_SESSION['productos'] as $producto) {
        $producto_id = $producto[0];
        $cantidad = $producto[1];

        $queryInsertDetalle = "INSERT INTO pedido_producto (pedido_id, producto_id, cantidad) VALUES ('$pedido_id', '$producto_id', '$cantidad')";
        mysqli_query($conn, $queryInsertDetalle);
      }
    }

    // Limpiar la sesión de productos después de registrar el pedido
    unset($_SESSION['productos']);

    header('Location: ../../layout/administrar-pedidos.php');
  } else {
    echo "Error: " . $queryInsertPedido . "<br>" . mysqli_error($conn);
  }
} else {
  echo "Método no permitido";
}
