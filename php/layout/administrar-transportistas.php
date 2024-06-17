<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

// Obtener transportistas
$queryTransportistas = "SELECT * FROM transportista";
$resultTransportistas = mysqli_query($conn, $queryTransportistas);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Administrar Transportistas</h2>
    <form id="transportistaForm" method="POST" action="../controllers/transportistaCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="nombre" class="mb-2">Nombre:</label>
          <input type="text" id="nombre" name="nombre" class="p-2 border rounded-lg" required>
        </div>
        <div class="flex flex-col">
          <label for="telefono" class="mb-2">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="email" class="mb-2">Email:</label>
          <input type="email" id="email" name="email" class="p-2 border rounded-lg">
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Transportistas Registrados:</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Nombre</th>
                <th class="px-4 py-2 border">Teléfono</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resultTransportistas->num_rows > 0) {
                while ($row = $resultTransportistas->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['transportista_id'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['nombre'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['telefono'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['email'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\"><a class='btn-editar' href='modificar-transportista.php?id=" . $row['transportista_id'] . "'><img src=\"../../assets/svg/edit.svg\" class=\"inline h-5\" alt=\"\"></a> <a class='btn-eliminar' href='../controllers/transportistaCtrl/eliminarCtrl.php?id=" . $row['transportista_id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'><img src=\"../../assets/svg/delete.svg\" class=\"inline h-5\" alt=\"\"></a></td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='5'>No hay transportistas disponibles</td></tr>";
              }
              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include('../components/footer.php'); ?>