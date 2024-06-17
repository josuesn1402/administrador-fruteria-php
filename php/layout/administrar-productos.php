<?php
include ('../config/connection.php');
include ('../config/session_check.php');
include ('../components/head.php');
include ('../components/sidebar.php');

$queryProductos = "SELECT producto_id, nombre, tipo, cantidad, precio FROM producto";
$resultProductos = mysqli_query($conn, $queryProductos);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4 xl font-bold mb-6 text-center">Administrar Productos</h2>
    <form id="compraForm" method="POST" action="../controllers/productoCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="nombre" class="mb-2">Nombre:</label>
          <input type="text" id="nombre" name="nombre" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="tipo" class="mb-2">Tipo:</label>
          <select id="tipo" name="tipo" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="Local">Local</option>
            <option value="Importado">Importado</option>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="cantidad" class="mb-2">Cantidad:</label>
          <input type="number" step="1" id="cantidad" name="cantidad" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="precio" class="mb-2">Precio:</label>
          <input type="number" step="0.01" id="precio" name="precio" class="p-2 border rounded-lg">
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Productos Registrados:</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Nombre</th>
                <th class="px-4 py-2 border">Tipo</th>
                <th class="px-4 py-2 border">Cantidad</th>
                <th class="px-4 py-2 border">Precio</th>
                <th class="px-4 py-2 border">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resultProductos->num_rows > 0) {
                while ($row = $resultProductos->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['nombre'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['producto_id'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['tipo'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['cantidad'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['precio'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\"><a class='btn-editar' href='modificar-producto.php?id=" . $row['producto_id'] . "'><img src=\"../../assets/svg/edit.svg\" class=\"inline h-5\" alt=\"\"></a> <a class='btn-eliminar' href='../controllers/productoCtrl/eliminarCtrl.php?id=" . $row['producto_id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'><img src=\"../../assets/svg/delete.svg\" class=\"inline h-5\" alt=\"\"></a></a></td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='7'>No hay productos disponibles</td></tr>";
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

<?php include ('../components/footer.php'); ?>