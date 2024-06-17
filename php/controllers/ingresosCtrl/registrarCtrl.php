<?php
include ('../config/connection.php');
include ('../config/session_check.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $proveedor = $_POST['proveedor'];
  $categoria = $_POST['categoria'];
  $articulo = $_POST['articulo'];
  $cantidad = $_POST['cantidad'];
  $precio_compra = $_POST['precio_compra'];
  $precio_venta = $_POST['precio_venta'];
  $descuento = $_POST['descuento'];
  $fecha = $_POST['fecha'];
  $total = $_POST['total'];

  // Insertar compra en la tabla 'ingreso'
  $queryIngreso = "INSERT INTO ingreso (idproveedor, tipo_comprobante, serie_comprobante, num_comprobante, fecha_hora, impuesto, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmtIngreso = $conn->prepare($queryIngreso);
  $tipo_comprobante = 'Factura'; // Ejemplo de tipo de comprobante
  $serie_comprobante = '001'; // Ejemplo de serie de comprobante
  $num_comprobante = '00001'; // Ejemplo de número de comprobante
  $impuesto = $total * 0.10; // Suponiendo que el impuesto es el 10% del total
  $estado = 'Pendiente'; // Ejemplo de estado
  $stmtIngreso->bind_param("issssds", $proveedor, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha, $impuesto, $estado);
  $stmtIngreso->execute();
  $idIngreso = $stmtIngreso->insert_id;

  // Insertar detalle de ingreso en la tabla 'detalle_ingreso'
  $queryDetalleIngreso = "INSERT INTO detalle_ingreso (idingreso, idarticulo, cantidad, precio_compra, precio_venta, descuento) VALUES (?, ?, ?, ?, ?, ?)";
  $stmtDetalleIngreso = $conn->prepare($queryDetalleIngreso);
  $stmtDetalleIngreso->bind_param("iiidd", $idIngreso, $articulo, $cantidad, $precio_compra, $precio_venta, $descuento);
  $stmtDetalleIngreso->execute();

  $stmtIngreso->close();
  $stmtDetalleIngreso->close();
  $conn->close();

  header("Location: dashboard-compras.php?status=success");
  exit();
}
?>