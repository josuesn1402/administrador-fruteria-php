<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

if (isset($_GET['id'])) {
  $idProducto = intval($_GET['id']);
  $sqlProducto = "SELECT * FROM producto WHERE producto_id = ?";
  if ($stmt = $conn->prepare($sqlProducto)) {
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $producto = $result->fetch_assoc();
    } else {
      echo "<p>Producto no encontrado</p>";
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
    <h2 class="text-4 xl font-bold mb-6 text-center">Modificar Productos</h2>
    <form id="compraForm" method="POST" action="../controllers/productoCtrl/modificarCtrl.php" class="grid gap-6">
      <input type="hidden" id="id" name="id" value="<?php echo $producto['producto_id']; ?>" required>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="nombre" class="mb-2">Nombre:</label>
          <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="tipo" class="mb-2">Tipo:</label>
          <select id="tipo" name="tipo" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="Local" <?php if ($producto['tipo'] == 'Local') {
                                    echo 'selected';
                                  }; ?>>Local</option>
            <option value="Importado" <?php if ($producto['tipo'] == 'Importado') {
                                        echo 'selected';
                                      }; ?>>Importado
            </option>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="cantidad" class="mb-2">Cantidad:</label>
          <input type="number" step="1" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="precio" class="mb-2">Precio:</label>
          <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" class="p-2 border rounded-lg">
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