<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

$queryDocumento = "SELECT documento_id, titulo, contenido FROM documento";
$resultDocumento = mysqli_query($conn, $queryDocumento);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Administrar Documentos</h2>
    <form id="documentoForm" method="POST" action="../controllers/documentoCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="titulo" class="mb-2">Título:</label>
          <input type="text" id="titulo" name="titulo" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="contenido" class="mb-2">Contenido:</label>
          <textarea id="contenido" name="contenido" class="p-2 border rounded-lg"></textarea>
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
                <th class="px-4 py-2 border">Título</th>
                <th class="px-4 py-2 border">Contenido</th>
                <th class="px-4 py-2 border">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resultDocumento->num_rows > 0) {
                while ($row = $resultDocumento->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['documento_id'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['titulo'] . "</td>";
                  echo "<td class=\"px-4 py-2 border\">" . $row['contenido'] . "</td>";
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