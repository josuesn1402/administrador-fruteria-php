<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

if (isset($_GET['id'])) {
  $idTransporte = intval($_GET['id']);
  $sqlTransporte = "SELECT * FROM medio_transporte WHERE medio_transporte_id = ?";
  if ($stmt = $conn->prepare($sqlTransporte)) {
    $stmt->bind_param("i", $idTransporte);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $transporte = $result->fetch_assoc();
    } else {
      echo "<p>Medio de transporte no encontrado</p>";
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
    <h2 class="text-4xl font-bold mb-6 text-center">Modificar Medio de Transporte</h2>
    <form id="transporteForm" method="POST" action="../controllers/medioTransporteCtrl/modificarCtrl.php" class="grid gap-6">
      <input type="hidden" id="id" name="id" value="<?php echo $transporte['medio_transporte_id']; ?>" required>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="tipo" class="mb-2">Tipo:</label>
          <input type="text" id="tipo" name="tipo" value="<?php echo $transporte['tipo']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="placa" class="mb-2">Placa:</label>
          <input type="text" id="placa" name="placa" value="<?php echo $transporte['placa']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="capacidad" class="mb-2">Capacidad:</label>
          <input type="number" step="1" id="capacidad" name="capacidad" value="<?php echo $transporte['capacidad']; ?>" class="p-2 border rounded-lg">
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