<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

if (isset($_GET['id'])) {
  $idDocumento = intval($_GET['id']);
  $sqlDocumento = "SELECT * FROM documento WHERE documento_id = ?";
  if ($stmt = $conn->prepare($sqlDocumento)) {
    $stmt->bind_param("i", $idDocumento);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $documento = $result->fetch_assoc();
    } else {
      echo "<p>Documento no encontrado</p>";
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

$conn->close();
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Modificar Documento</h2>
    <form id="documentoForm" method="POST" action="../controllers/documentoCtrl/modificarCtrl.php" class="grid gap-6">
      <input type="hidden" id="id" name="id" value="<?php echo $documento['documento_id']; ?>" required>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="tipo_documento" class="mb-2">Tipo:</label>
          <select id="tipo_documento" name="tipo_documento" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="Factura" <?php if ($documento['tipo_documento'] == 'Factura') echo 'selected'; ?>>Factura</option>
            <option value="Boleta" <?php if ($documento['tipo_documento'] == 'Boleta') echo 'selected'; ?>>Boleta</option>
            <option value="Guía de Pedido" <?php if ($documento['tipo_documento'] == 'Guía de Pedido') echo 'selected'; ?>>Guía de Pedido</option>
            <option value="Nota de Crédito" <?php if ($documento['tipo_documento'] == 'Nota de Crédito') echo 'selected'; ?>>Nota de Crédito</option>
            <option value="Nota de Débito" <?php if ($documento['tipo_documento'] == 'Nota de Débito') echo 'selected'; ?>>Nota de Débito</option>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="numero" class="mb-2">Número:</label>
          <input type="text" id="numero" name="numero" class="p-2 border rounded-lg" value="<?php echo $documento['numero']; ?>">
        </div>
        <div class="flex flex-col">
          <label for="fecha_emision" class="mb-2">Fecha de Emisión:</label>
          <input type="date" id="fecha_emision" name="fecha_emision" class="p-2 border rounded-lg" value="<?php echo $documento['fecha_emision']; ?>">
        </div>
        <div class="flex flex-col">
          <label for="monto" class="mb-2">Monto:</label>
          <input type="number" step="0.1" id="monto" name="monto" class="p-2 border rounded-lg" value="<?php echo $documento['monto']; ?>">
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Modificar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include('../components/footer.php'); ?>