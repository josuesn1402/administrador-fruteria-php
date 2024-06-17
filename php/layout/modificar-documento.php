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
          <label for="titulo" class="mb-2">Título:</label>
          <input type="text" id="titulo" name="titulo" value="<?php echo $documento['titulo']; ?>" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="contenido" class="mb-2">Contenido:</label>
          <textarea id="contenido" name="contenido" class="p-2 border rounded-lg"><?php echo $documento['contenido']; ?></textarea>
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