<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

if (isset($_GET['id'])) {
  $pedido_id = intval($_GET['id']);
  $queryPedido = "SELECT * FROM pedido WHERE pedido_id = ?";
  if ($stmt = $conn->prepare($queryPedido)) {
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $pedido = $result->fetch_assoc();
    } else {
      echo "<p>Pedido no encontrado</p>";
      exit;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
    exit;
  }
} else {
  echo "<p>ID no proporcionado</p>";
  exit;
}

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
    <h2 class="text-4xl font-bold mb-6 text-center">Modificar Pedido</h2>
    <form id="pedidoForm" method="POST" action="../controllers/pedidoCtrl/modificarCtrl.php" class="grid gap-6">
      <input type="hidden" name="pedido_id" value="<?php echo $pedido['pedido_id']; ?>">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="codigo_pedido" class="mb-2">Código de Pedido:</label>
          <input type="text" id="codigo_pedido" name="codigo_pedido" class="p-2 border rounded-lg" value="<?php echo $pedido['codigo_pedido']; ?>" required>
        </div>
        <div class="flex flex-col">
          <label for="fecha_pedido" class="mb-2">Fecha de Pedido:</label>
          <input type="date" id="fecha_pedido" name="fecha_pedido" class="p-2 border rounded-lg" value="<?php echo $pedido['fecha_pedido']; ?>" required>
        </div>
        <div class="flex flex-col">
          <label for="cliente_id" class="mb-2">Cliente:</label>
          <select id="cliente_id" name="cliente_id" class="p-2 border rounded-lg">
            <?php while ($cliente = mysqli_fetch_assoc($resultClientes)) { ?>
              <option value="<?php echo $cliente['cliente_id']; ?>" <?php if ($cliente['cliente_id'] == $pedido['cliente_id']) echo 'selected'; ?>>
                <?php echo $cliente['nombre']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="documento_id" class="mb-2">Documento:</label>
          <select id="documento_id" name="documento_id" class="p-2 border rounded-lg">
            <?php while ($documento = mysqli_fetch_assoc($resultDocumentos)) { ?>
              <option value="<?php echo $documento['documento_id']; ?>" <?php if ($documento['documento_id'] == $pedido['documento_id']) echo 'selected'; ?>>
                <?php echo $documento['tipo_documento'] . " - " . $documento['numero']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="medio_transporte_id" class="mb-2">Medio de Transporte:</label>
          <select id="medio_transporte_id" name="medio_transporte_id" class="p-2 border rounded-lg">
            <?php while ($transporte = mysqli_fetch_assoc($resultMediosTransporte)) { ?>
              <option value="<?php echo $transporte['medio_transporte_id']; ?>" <?php if ($transporte['medio_transporte_id'] == $pedido['medio_transporte_id']) echo 'selected'; ?>>
                <?php echo $transporte['tipo']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="transportista_id" class="mb-2">Transportista:</label>
          <select id="transportista_id" name="transportista_id" class="p-2 border rounded-lg">
            <?php while ($transportista = mysqli_fetch_assoc($resultTransportistas)) { ?>
              <option value="<?php echo $transportista['transportista_id']; ?>" <?php if ($transportista['transportista_id'] == $pedido['transportista_id']) echo 'selected'; ?>>
                <?php echo $transportista['nombre']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="fecha_salida" class="mb-2">Fecha de Salida:</label>
          <input type="date" id="fecha_salida" name="fecha_salida" class="p-2 border rounded-lg" value="<?php echo $pedido['fecha_salida']; ?>" required>
        </div>
        <div class="flex flex-col">
          <label for="fecha_llegada" class="mb-2">Fecha de Llegada:</label>
          <input type="date" id="fecha_llegada" name="fecha_llegada" class="p-2 border rounded-lg" value="<?php echo $pedido['fecha_llegada']; ?>" required>
        </div>
        <div class="flex flex-col">
          <label for="estado" class="mb-2">Estado:</label>
          <select id="estado" name="estado" class="p-2 border rounded-lg">
            <option value="Pendiente" <?php if ($pedido['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="En Proceso" <?php if ($pedido['estado'] == 'En Proceso') echo 'selected'; ?>>En Proceso</option>
            <option value="Completado" <?php if ($pedido['estado'] == 'Completado') echo 'selected'; ?>>Completado</option>
          </select>
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Modificar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include('../components/footer.php'); ?>