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
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Registrar Pedidos</h2>
    <form id="pedidoForm" method="POST" action="../controllers/pedidoCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="codigo_pedido" class="mb-2">Código de Pedido:</label>
          <input type="text" id="codigo_pedido" name="codigo_pedido" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="fecha_pedido" class="mb-2">Fecha de Pedido:</label>
          <input type="date" id="fecha_pedido" name="fecha_pedido" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="cliente_id" class="mb-2">Cliente:</label>
          <select id="cliente_id" name="cliente_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultClientes->num_rows > 0) {
              while ($row = $resultClientes->fetch_assoc()) {
                echo "<option value='" . $row['cliente_id'] . "'>" . $row['nombre'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="documento_id" class="mb-2">Documento:</label>
          <select id="documento_id" name="documento_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultDocumentos->num_rows > 0) {
              while ($row = $resultDocumentos->fetch_assoc()) {
                echo "<option value='" . $row['documento_id'] . "'>" . $row['tipo_documento'] . " - " . $row['numero'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="medio_transporte_id" class="mb-2">Medio de Transporte:</label>
          <select id="medio_transporte_id" name="medio_transporte_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultMediosTransporte->num_rows > 0) {
              while ($row = $resultMediosTransporte->fetch_assoc()) {
                echo "<option value='" . $row['medio_transporte_id'] . "'>" . $row['tipo'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="transportista_id" class="mb-2">Transportista:</label>
          <select id="transportista_id" name="transportista_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultTransportistas->num_rows > 0) {
              while ($row = $resultTransportistas->fetch_assoc()) {
                echo "<option value='" . $row['transportista_id'] . "'>" . $row['nombre'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="fecha_salida" class="mb-2">Fecha de Salida:</label>
          <input type="date" id="fecha_salida" name="fecha_salida" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="fecha_llegada" class="mb-2">Fecha de Llegada:</label>
          <input type="date" id="fecha_llegada" name="fecha_llegada" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="estado" class="mb-2">Estado:</label>
          <select id="estado" name="estado" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="En Transito">En Transito</option>
            <option value="Entregado">Entregado</option>
          </select>
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include('../components/footer.php'); ?>