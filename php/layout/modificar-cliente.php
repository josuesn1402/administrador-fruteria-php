<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

if (isset($_GET['id'])) {
  $idCliente = intval($_GET['id']);
  $sqlCliente = "SELECT * FROM cliente WHERE cliente_id = ?";
  if ($stmt = $conn->prepare($sqlCliente)) {
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $cliente = $result->fetch_assoc();
    } else {
      echo "<p>Cliente no encontrado</p>";
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
    <h2 class="text-4xl font-bold mb-6 text-center">Modificar Cliente</h2>
    <form id="clienteForm" method="POST" action="../controllers/clienteCtrl/modificarCtrl.php" class="grid gap-6">
      <input type="hidden" id="id" name="id" value="<?php echo $cliente['cliente_id']; ?>" required>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="nombre" class="mb-2">Nombre:</label>
          <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="direccion" class="mb-2">Dirección:</label>
          <input type="text" id="direccion" name="direccion" value="<?php echo $cliente['direccion']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="telefono" class="mb-2">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="email" class="mb-2">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo $cliente['email']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="tipo" class="mb-2">Tipo:</label>
          <select id="tipo" name="tipo" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="Local" <?php if ($cliente['tipo'] == 'Local') {
                                    echo 'selected';
                                  }; ?>>Local</option>
            <option value="Provincial" <?php if ($cliente['tipo'] == 'Provincial') {
                                          echo 'selected';
                                        }; ?>>Provincial
            </option>
          </select>
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