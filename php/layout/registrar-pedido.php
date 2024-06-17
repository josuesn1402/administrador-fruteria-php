<?php
include('../config/connection.php');
include('../config/session_check.php');
include('../components/head.php');
include('../components/sidebar.php');

// Inicializar el array de productos en la sesión si no existe
if (!isset($_SESSION['productos'])) {
  $_SESSION['productos'] = [];
}

// Obtener datos para los select
$queryClientes = "SELECT cliente_id, nombre FROM cliente";
$resultClientes = mysqli_query($conn, $queryClientes);

$queryDocumentos = "SELECT documento_id, tipo_documento, numero FROM documento";
$resultDocumentos = mysqli_query($conn, $queryDocumentos);

$queryMediosTransporte = "SELECT medio_transporte_id, tipo FROM medio_transporte";
$resultMediosTransporte = mysqli_query($conn, $queryMediosTransporte);

$queryTransportistas = "SELECT transportista_id, nombre FROM transportista";
$resultTransportistas = mysqli_query($conn, $queryTransportistas);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold mb-6 text-center">Registrar Pedidos</h2>
    <form id="pedidoForm" method="POST" action="../controllers/pedidoCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="codigo_pedido" class="mb-2">Código de Pedido:</label>
          <input type="text" id="codigo_pedido" name="codigo_pedido" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="fecha_pedido" class="mb-2">Fecha de Pedido:</label>
          <input type="date" id="fecha_pedido" name="fecha_pedido" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="cliente_id" class="mb-2">Cliente:</label>
          <select id="cliente_id" name="cliente_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultClientes->num_rows > 0) {
              while ($row = $resultClientes->fetch_assoc()) {
                echo "<option value='" . $row['cliente_id'] . "'>" . $row['nombre'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="documento_id" class="mb-2">Documento:</label>
          <select id="documento_id" name="documento_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultDocumentos->num_rows > 0) {
              while ($row = $resultDocumentos->fetch_assoc()) {
                echo "<option value='" . $row['documento_id'] . "'>" . $row['tipo_documento'] . " - " . $row['numero'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="medio_transporte_id" class="mb-2">Medio de Transporte:</label>
          <select id="medio_transporte_id" name="medio_transporte_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultMediosTransporte->num_rows > 0) {
              while ($row = $resultMediosTransporte->fetch_assoc()) {
                echo "<option value='" . $row['medio_transporte_id'] . "'>" . $row['tipo'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="transportista_id" class="mb-2">Transportista:</label>
          <select id="transportista_id" name="transportista_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            if ($resultTransportistas->num_rows > 0) {
              while ($row = $resultTransportistas->fetch_assoc()) {
                echo "<option value='" . $row['transportista_id'] . "'>" . $row['nombre'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="fecha_salida" class="mb-2">Fecha de Salida:</label>
          <input type="date" id="fecha_salida" name="fecha_salida" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="fecha_llegada" class="mb-2">Fecha de Llegada:</label>
          <input type="date" id="fecha_llegada" name="fecha_llegada" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="estado" class="mb-2">Estado:</label>
          <select id="estado" name="estado" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="En Transito">En Transito</option>
            <option value="Entregado">Entregado</option>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="producto_id" class="mb-2">Producto:</label>
          <select id="producto_id" name="producto_id" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php
            // Consulta para obtener productos
            $queryProductos = "SELECT producto_id, nombre, precio FROM producto";
            $resultProductos = mysqli_query($conn, $queryProductos);
            if ($resultProductos->num_rows > 0) {
              while ($row = $resultProductos->fetch_assoc()) {
                echo "<option value='" . $row['producto_id'] . "' data-precio='" . $row['precio'] . "'>" . $row['nombre'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="cantidad" class="mb-2">Cantidad:</label>
          <input type="number" id="cantidad" name="cantidad" class="p-2 border rounded-lg" min="1">
        </div>
        <div class="flex flex-col">
          <label for="cantidad" class="mb-2">&nbsp;</label>
          <button type="button" id="agregarProducto" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Agregar Producto</button>
        </div>
      </div>
      <!-- Tabla para mostrar productos seleccionados -->
      <div class="mt-6">
        <h3 class="text-xl font-bold mb-4">Productos Seleccionados:</h3>
        <table id="tablaProductos" class="min-w-full bg-white border">
          <thead>
            <tr>
              <th class="px-4 py-2 border">Producto</th>
              <th class="px-4 py-2 border">Precio Unitario</th>
              <th class="px-4 py-2 border">Cantidad</th>
              <th class="px-4 py-2 border">Subtotal</th>
              <th class="px-4 py-2 border">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Aquí se agregarán dinámicamente las filas de productos seleccionados -->
            <?php
            if (isset($_SESSION['productos']) && !empty($_SESSION['productos'])) {
              foreach ($_SESSION['productos'] as $producto) {
                $productoId = $producto[0];
                $cantidad = $producto[1];

                // Obtener detalles del producto de la base de datos
                $queryProducto = "SELECT nombre, precio FROM producto WHERE producto_id = $productoId";
                $resultProducto = mysqli_query($conn, $queryProducto);
                if ($resultProducto->num_rows > 0) {
                  $productoData = $resultProducto->fetch_assoc();
                  $nombreProducto = $productoData['nombre'];
                  $precio = $productoData['precio'];
                  $subtotal = $precio * $cantidad;
                  echo "<tr>
                                <td class='px-4 py-2 border'>{$nombreProducto}</td>
                                <td class='px-4 py-2 border'>" . number_format($precio, 2) . "</td>
                                <td class='px-4 py-2 border'>{$cantidad}</td>
                                <td class='px-4 py-2 border'>" . number_format($subtotal, 2) . "</td>
                                <td class='px-4 py-2 border'>
                                  <button type='button' class='bg-red-500 text-white px-3 py-1 rounded-md eliminarProducto'>Eliminar</button>
                                </td>
                              </tr>";
                }
              }
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="px-4 py-2 text-right font-bold">Total</td>
              <td id="total" class="px-4 py-2 font-bold">0.00</td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar</button>
        </div>
      </div>
    </form>
  </div>
</section>

<script>
  // Script para agregar productos a la tabla dinámicamente y calcular total
  document.addEventListener('DOMContentLoaded', function() {
    const tablaProductos = document.getElementById('tablaProductos');
    const btnAgregar = document.getElementById('agregarProducto');
    const productoSelect = document.getElementById('producto_id');
    const cantidadInput = document.getElementById('cantidad');
    const totalElement = document.getElementById('total');
    let totalPedido = 0;

    // Calcular total inicial
    document.querySelectorAll('#tablaProductos tbody tr').forEach(row => {
      const subtotal = parseFloat(row.querySelector('td:nth-child(4)').textContent);
      totalPedido += subtotal;
    });
    totalElement.textContent = totalPedido.toFixed(2);

    btnAgregar.addEventListener('click', function() {
      const productoSeleccionado = productoSelect.value;
      const cantidad = parseInt(cantidadInput.value);
      const precio = parseFloat(productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio'));
      const subtotal = precio * cantidad;

      if (productoSeleccionado && cantidad > 0) {
        const nombreProducto = productoSelect.options[productoSelect.selectedIndex].text;

        // Buscar si el producto ya está en la tabla
        let productoExistente = false;
        tablaProductos.querySelectorAll('tbody tr').forEach(row => {
          if (row.querySelector('td:first-child').textContent === nombreProducto) {
            // Si el producto ya está en la tabla, actualizar la cantidad y el subtotal
            const cantidadCell = row.querySelector('td:nth-child(3)');
            const subtotalCell = row.querySelector('td:nth-child(4)');
            const cantidadActual = parseInt(cantidadCell.textContent);
            const nuevoSubtotal = (cantidadActual + cantidad) * precio;

            cantidadCell.textContent = cantidadActual + cantidad;
            subtotalCell.textContent = nuevoSubtotal.toFixed(2);

            // Actualizar el total del pedido
            totalPedido += subtotal;
            totalElement.textContent = totalPedido.toFixed(2);

            productoExistente = true;
          }
        });

        // Si el producto no está en la tabla, agregar una nueva fila
        if (!productoExistente) {
          const newRow = document.createElement('tr');
          newRow.innerHTML = `
            <td class="px-4 py-2 border">${nombreProducto}</td>
            <td class="px-4 py-2 border">${precio.toFixed(2)}</td>
            <td class="px-4 py-2 border">${cantidad}</td>
            <td class="px-4 py-2 border">${subtotal.toFixed(2)}</td>
            <td class="px-4 py-2 border">
              <button type="button" class="bg-red-500 text-white px-3 py-1 rounded-md eliminarProducto">Eliminar</button>
            </td>
          `;
          tablaProductos.querySelector('tbody').appendChild(newRow);

          // Actualizar total
          totalPedido += subtotal;
          totalElement.textContent = totalPedido.toFixed(2);

          // Añadir evento de eliminación al botón recién agregado
          newRow.querySelector('.eliminarProducto').addEventListener('click', function() {
            const fila = this.closest('tr');
            const subtotalEliminar = parseFloat(fila.querySelector('td:nth-child(4)').textContent);
            totalPedido -= subtotalEliminar;
            totalElement.textContent = totalPedido.toFixed(2);
            fila.remove();
          });

          // Guardar el producto en la sesión
          guardarProductoEnSesion(productoSeleccionado, cantidad);
        }

        // Limpiar campos después de agregar
        productoSelect.value = '';
        cantidadInput.value = '1';
      }
    });

    function guardarProductoEnSesion(productoId, cantidad) {
      fetch('../controllers/pedidoCtrl/guardarProductoSesion.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            productoId,
            cantidad
          })
        }).then(response => response.json())
        .then(data => {
          console.log('Producto guardado en la sesión', data);
        });
    }
  });
</script>

<?php include('../components/footer.php'); ?>