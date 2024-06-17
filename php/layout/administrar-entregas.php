<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

$queryEntrega = "SELECT entrega_id, fecha, descripcion, destino, estado FROM entrega";
$resultEntrega = mysqli_query($conn, $queryEntrega);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Administrar Entregas</h2>
    <form id="entregaForm" method="POST" action="../controllers/entregaCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="fecha" class="mb-2">Fecha:</label>
          <input type="date" id="fecha" name="fecha" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="descripcion" class="mb-2">Descripción:</label>
          <textarea id="descripcion" name="descripcion" class="p-2 border rounded-lg"></textarea>
        </div>
        <div class="flex flex-col">
          <label for="destino" class="mb-2">Destino:</label>
          <input type="text" id="destino" name="destino" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="estado" class="mb-2">Estado:</label>
          <select id="estado" name="estado" class="p-2 border rounded-lg">
            <option value="Pendiente">Pendiente</option>
            <option value="En Proceso">En Proceso</option>
            <option value="Completado">Completado</option>
          </select>
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Entregas Registradas:</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Fecha</th>
                <th class="px-4 py-2 border">Descripción</th>
                <th class="px-4 py-2 border">Destino</th>
                <th class="px-4 py-2 border">Estado</th>
                <th class="px-4 py-2 border">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resultEntrega->num_rows > 0) {
                while ($row = $resultEntrega->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['entrega_id'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['fecha'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['descripcion'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['destino'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['estado'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\"><a class='btn-editar' href='modificar-entrega.php?id=" . $row['entrega_id'] . "'><img src=\"../../assets/svg/edit.svg\" class=\"inline h-5\" alt=\"\"></a> <a class='btn-eliminar' href='../controllers/entregaCtrl/eliminarCtrl.php?id=" . $row['entrega_id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'><img src=\"../../assets/svg/delete.svg\" class=\"inline h-5\" alt=\"\"></a></a></td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='6'>No hay entregas disponibles</td></tr>";
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