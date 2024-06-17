<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

$transportista_id = $_GET['id'];
$queryTransportista = "SELECT * FROM transportista WHERE transportista_id = ?";
$stmt = $conn->prepare($queryTransportista);
$stmt->bind_param("i", $transportista_id);
$stmt->execute();
$result = $stmt->get_result();
$transportista = $result->fetch_assoc();
$stmt->close();
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Modificar Transportista</h2>
    <form id="transportistaForm" method="POST" action="../controllers/transportistaCtrl/modificarCtrl.php" class="grid gap-6">
      <input type="hidden" name="transportista_id" value="<?php echo $transportista['transportista_id']; ?>">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="nombre" class="mb-2">Nombre:</label>
          <input type="text" id="nombre" name="nombre" class="p-2 border rounded-lg" value="<?php echo $transportista['nombre']; ?>" required>
        </div>
        <div class="flex flex-col">
          <label for="telefono" class="mb-2">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" class="p-2 border rounded-lg" value="<?php echo $transportista['telefono']; ?>">
        </div>
        <div class="flex flex-col">
          <label for="email" class="mb-2">Email:</label>
          <input type="email" id="email" name="email" class="p-2 border rounded-lg" value="<?php echo $transportista['email']; ?>">
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