<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

// Obtener datos para los select
$queryClientes = "SELECT cliente_id, nombre FROM cliente";
$resultClientes = mysqli_query($conn, $queryClientes);

$queryDocumentos = "SELECT documento_id, tipo_documento, numero FROM documento";
$resultDocumentos = mysqli_query($conn, $queryDocumentos);

$queryMediosTransporte = "SELECT medio_transporte_id, tipo FROM medio_transporte";
$resultMediosTransporte = mysqli_query($conn, $queryMediosTransporte);

$queryTransportistas = "SELECT transportista_id, nombre FROM transportista";
$resultTransportistas = mysqli_query($conn, $queryTransportistas);

$queryPedidos = "SELECT p.pedido_id, p.codigo_pedido, p.fecha_pedido, 
                        c.nombre AS nombre_cliente, 
                        d.tipo_documento, d.numero AS numero_documento, 
                        mt.tipo AS tipo_transporte, 
                        t.nombre AS nombre_transportista, 
                        p.fecha_salida, p.fecha_llegada, p.estado
                 FROM pedido p
                 INNER JOIN cliente c ON p.cliente_id = c.cliente_id
                 INNER JOIN documento d ON p.documento_id = d.documento_id
                 INNER JOIN medio_transporte mt ON p.medio_transporte_id = mt.medio_transporte_id
                 INNER JOIN transportista t ON p.transportista_id = t.transportista_id";
$resultPedidos = mysqli_query($conn, $queryPedidos);
?>

<section class="p-8">
  <h2 class="text-4xl font-bold mb-6 text-center">Administrar Pedidos</h2>
  <div class="grid gap-4">
    <div class="flex justify-between">
      <a href="./registrar-pedido.php" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</a>
    </div>
    <div class="mt-6">
      <h3 class="text-xl font-bold mb-4">Pedidos Registrados:</h3>
      <table class="min-w-full bg-white border">
        <thead>
          <tr>
            <th class="px-4 py-2 text-xs border">ID</th>
            <th class="px-4 py-2 text-xs border">Código</th>
            <th class="px-4 py-2 text-xs border">Fecha Pedido</th>
            <th class="px-4 py-2 text-xs border">Cliente</th>
            <th class="px-4 py-2 text-xs border">Documento</th>
            <th class="px-4 py-2 text-xs border">Transporte</th>
            <th class="px-4 py-2 text-xs border">Transportista</th>
            <th class="px-4 py-2 text-xs border">Fecha Salida</th>
            <th class="px-4 py-2 text-xs border">Fecha Llegada</th>
            <th class="px-4 py-2 text-xs border">Estado</th>
            <th class="px-4 py-2 text-xs border">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($resultPedidos->num_rows > 0) {
            while ($row = $resultPedidos->fetch_assoc()) {
              echo "<tr>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['pedido_id'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['codigo_pedido'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['fecha_pedido'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['nombre_cliente'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['tipo_documento'] . " - " . $row['numero_documento'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['tipo_transporte'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['nombre_transportista'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['fecha_salida'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['fecha_llegada'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\">" . $row['estado'] . "</td>";
              echo "<td class=\"px-4 py-2 text-xs border\"><a class='btn-editar' href='modificar-pedido.php?id=" . $row['pedido_id'] . "'><img src=\"../../assets/svg/edit.svg\" class=\"inline h-5\" alt=\"\"></a> <a class='btn-eliminar' href='../controllers/pedidoCtrl/eliminarCtrl.php?id=" . $row['pedido_id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'><img src=\"../../assets/svg/delete.svg\" class=\"inline h-5\" alt=\"\"></a></a></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='11'>No hay pedidos disponibles</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php include('../components/footer.php'); ?>