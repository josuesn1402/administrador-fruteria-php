<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

$queryTransporte = "SELECT medio_transporte_id, tipo, placa, capacidad FROM medio_transporte";
$resultTransporte = mysqli_query($conn, $queryTransporte);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Administrar Medio de Transporte</h2>
    <form id="transporteForm" method="POST" action="../controllers/medioTransporteCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="tipo" class="mb-2">Tipo:</label>
          <input type="text" id="tipo" name="tipo" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="placa" class="mb-2">Placa:</label>
          <input type="text" id="placa" name="placa" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="capacidad" class="mb-2">Capacidad:</label>
          <input type="number" step="1" id="capacidad" name="capacidad" class="p-2 border rounded-lg">
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Medios de Transporte Registrados:</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Tipo</th>
                <th class="px-4 py-2 border">Placa</th>
                <th class="px-4 py-2 border">Capacidad</th>
                <th class="px-4 py-2 border">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resultTransporte->num_rows > 0) {
                while ($row = $resultTransporte->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['medio_transporte_id'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['tipo'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['placa'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['capacidad'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\"><a class='btn-editar' href='modificar-medio-transporte.php?id=" . $row['medio_transporte_id'] . "'><img src=\"../../assets/svg/edit.svg\" class=\"inline h-5\" alt=\"\"></a> <a class='btn-eliminar' href='../controllers/medioTransporteCtrl/eliminarCtrl.php?id=" . $row['medio_transporte_id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'><img src=\"../../assets/svg/delete.svg\" class=\"inline h-5\" alt=\"\"></a></a></td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='4'>No hay medios de transporte disponibles</td></tr>";
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