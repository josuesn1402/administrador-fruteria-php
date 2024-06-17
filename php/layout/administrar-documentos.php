<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

$queryDocumento = "SELECT documento_id, tipo_documento, numero, fecha_emision, monto FROM documento";
$resultDocumento = mysqli_query($conn, $queryDocumento);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Administrar Documentos</h2>
    <form id="documentoForm" method="POST" action="../controllers/documentoCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="tipo_documento" class="mb-2">Tipo:</label>
          <select id="tipo_documento" name="tipo_documento" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="Factura">Factura</option>
            <option value="Boleta">Boleta</option>
            <option value="Guía de Pedido">Guía de Pedido</option>
            <option value="Nota de Crédito">Nota de Crédito</option>
            <option value="Nota de Débito">Nota de Débito</option>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="numero" class="mb-2">Número:</label>
          <input type="text" id="numero" name="numero" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="fecha_emision" class="mb-2">Fecha de Emisión:</label>
          <input type="date" id="fecha_emision" name="fecha_emision" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="monto" class="mb-2">Monto:</label>
          <input type="number" step="0.1" id="monto" name="monto" class="p-2 border rounded-lg">
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Documentos Registrados:</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Tipo</th>
                <th class="px-4 py-2 border">Número</th>
                <th class="px-4 py-2 border">Fecha</th>
                <th class="px-4 py-2 border">Monto</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resultDocumento->num_rows > 0) {
                while ($row = $resultDocumento->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['documento_id'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['tipo_documento'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['numero'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['fecha_emision'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['monto'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\"><a class='btn-editar' href='modificar-documento.php?id=" . $row['documento_id'] . "'><img src=\"../../assets/svg/edit.svg\" class=\"inline h-5\" alt=\"\"></a> <a class='btn-eliminar' href='../controllers/documentoCtrl/eliminarCtrl.php?id=" . $row['documento_id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'><img src=\"../../assets/svg/delete.svg\" class=\"inline h-5\" alt=\"\"></a></a></td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='4'>No hay documentos disponibles</td></tr>";
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