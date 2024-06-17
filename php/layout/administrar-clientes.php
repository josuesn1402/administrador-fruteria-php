<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

$queryClientes = "SELECT cliente_id, nombre, direccion, telefono, email, tipo FROM cliente";
$resultClientes = mysqli_query($conn, $queryClientes);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Administrar Clientes</h2>
    <form id="clienteForm" method="POST" action="../controllers/clienteCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="nombre" class="mb-2">Nombre:</label>
          <input type="text" id="nombre" name="nombre" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="direccion" class="mb-2">Dirección:</label>
          <input type="text" id="direccion" name="direccion" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="telefono" class="mb-2">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="email" class="mb-2">Email:</label>
          <input type="email" id="email" name="email" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="tipo" class="mb-2">Tipo:</label>
          <select id="tipo" name="tipo" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="Local">Local</option>
            <option value="Provincial">Provincial</option>
          </select>
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Clientes Registrados:</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Nombre</th>
                <th class="px-4 py-2 border">Dirección</th>
                <th class="px-4 py-2 border">Teléfono</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Tipo</th>
                <th class="px-4 py-2 border">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resultClientes->num_rows > 0) {
                while ($row = $resultClientes->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['cliente_id'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['nombre'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['direccion'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['telefono'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['email'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['tipo'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\"><a class='btn-editar' href='modificar-cliente.php?id=" . $row['cliente_id'] . "'><img src=\"../../assets/svg/edit.svg\" class=\"inline h-5\" alt=\"\"></a> <a class='btn-eliminar' href='../controllers/clienteCtrl/eliminarCtrl.php?id=" . $row['cliente_id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'><img src=\"../../assets/svg/delete.svg\" class=\"inline h-5\" alt=\"\"></a></a></td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='7'>No hay clientes disponibles</td></tr>";
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