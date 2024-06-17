<?php
include ('../config/connection.php');
include ('../config/session_check.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $tipoDocumento = $_POST['tipoDocumento'];
  $codigoEmpleado = $_POST['codigoEmpleado'];
  $cliente = $_POST['cliente'];
  $articulo = $_POST['articulo'];
  $cantidad = $_POST['cantidad'];
  $precio = $_POST['precio'];
  $fecha = $_POST['fecha'];
  $total = $_POST['total'];

  // Insertar venta en la tabla 'venta'
  $queryVenta = "INSERT INTO venta (tipo_documento, codigo_empleado, id_cliente, fecha, total) VALUES (?, ?, ?, ?, ?)";
  $stmtVenta = $conn->prepare($queryVenta);
  $stmtVenta->bind_param("siisd", $tipoDocumento, $codigoEmpleado, $cliente, $fecha, $total);
  $stmtVenta->execute();
  $idVenta = $stmtVenta->insert_id;

  // Insertar detalle de venta en la tabla 'detalle_venta'
  $queryDetalleVenta = "INSERT INTO detalle_venta (id_venta, id_articulo, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
  $stmtDetalleVenta = $conn->prepare($queryDetalleVenta);
  $stmtDetalleVenta->bind_param("iiid", $idVenta, $articulo, $cantidad, $precio);
  $stmtDetalleVenta->execute();

  $stmtVenta->close();
  $stmtDetalleVenta->close();
  $conn->close();

  header("Location: dashboard-compras.php?status=success");
  exit();
}
?>