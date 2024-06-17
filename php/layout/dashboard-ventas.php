<?php
include ('../config/connection.php');
include ('../config/session_check.php');
include ('../components/head.php');
include ('../components/sidebar.php');

// Consulta de clientes
$queryClientes = "SELECT idpersona, nombre FROM persona WHERE tipo_persona = 'Cliente'";
$resultClientes = mysqli_query($conn, $queryClientes);

// Consulta de artículos
$queryArticulos = "SELECT idarticulo, idcategoria, codigo, nombre, precio_venta FROM articulo";
$resultArticulos = mysqli_query($conn, $queryArticulos);

// Consulta de categoría
$queryCategorias = "SELECT idcategoria, nombre FROM categoria";
$resultCategorias = mysqli_query($conn, $queryCategorias);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6">Venta de Artículos</h2>
    <form id="pedidoForm" method="POST" action="../controllers/ventasCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="tipoDocumento" class="mb-2">Tipo de Documento:</label>
          <select id="tipoDocumento" name="tipoDocumento" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <option value="1">Factura</option>
            <option value="2">Boleta</option>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="cliente" class="mb-2">Cliente:</label>
          <select id="cliente" name="cliente" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php while ($row = mysqli_fetch_assoc($resultClientes)): ?>
              <option value="<?php echo $row['idpersona']; ?>"><?php echo $row['nombre']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="serie_comprobante" class="mb-2">Serie de comprobante:</label>
          <input type="text" id="serie_comprobante" name="serie_comprobante" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="num_comprobante" class="mb-2">Número de Comprobante:</label>
          <input type="text" id="num_comprobante" name="num_comprobante" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="categoria" class="mb-2">Categoría:</label>
          <select id="categoria" name="categoria" class="p-2 border rounded-lg" onchange="filtrarArticulos()">
            <option value="">Seleccionar</option>
            <?php while ($row = mysqli_fetch_assoc($resultCategorias)): ?>
              <option value="<?php echo $row['idcategoria']; ?>"><?php echo $row['nombre']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="articulo" class="mb-2">Artículo:</label>
          <select id="articulo" name="articulo" class="p-2 border rounded-lg" onchange="actualizarPrecio()">
            <option value="">Seleccionar</option>
            <?php while ($row = mysqli_fetch_assoc($resultArticulos)): ?>
              <option value="<?php echo $row['idarticulo']; ?>" data-categoria="<?php echo $row['idcategoria']; ?>"
                data-precio="<?php echo $row['precio_venta']; ?>">
                <?php echo $row['nombre']; ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="cantidad" class="mb-2">Cantidad:</label>
          <input type="number" id="cantidad" name="cantidad" class="p-2 border rounded-lg" oninput="calcularTotal()">
        </div>
        <div class="flex flex-col">
          <label for="precio" class="mb-2">Precio:</label>
          <input type="number" step="0.01" id="precio" name="precio" class="p-2 border rounded-lg" readonly>
        </div>
        <div class="flex flex-col">
          <label for="descuento" class="mb-2">Descuento:</label>
          <input type="number" step="0.01" id="descuento" name="descuento" class="p-2 border rounded-lg"
            oninput="calcularTotal()">
        </div>
        <div class="flex flex-col">
          <label for="fecha" class="mb-2">Fecha:</label>
          <input type="date" id="fecha" name="fecha" class="p-2 border rounded-lg" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="flex flex-col">
          <label for="impuesto" class="mb-2">Impuesto:</label>
          <input type="text" id="impuesto" name="impuesto" class="p-2 border rounded-lg" readonly>
        </div>
        <div class="flex flex-col">
          <label for="total" class="mb-2">Total:</label>
          <input type="text" id="total" name="total" class="p-2 border rounded-lg" readonly>
        </div>
      </div>
      <div class="grid gap-4">
        <div class="flex justify-between">
          <button type="button" onclick="calcularTotal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Calcular
            Total</button>
          <button type="button" onclick="agregarPedido()" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Agregar
            Articulo</button>
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar Venta</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Detalles del Pedido</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">Artículo</th>
                <th class="px-4 py-2 border">Cantidad</th>
                <th class="px-4 py-2 border">Precio Unitario</th>
                <th class="px-4 py-2 border">Subtotal</th>
              </tr>
            </thead>
            <tbody id="detallesPedido">
              <!-- Detalles de pedidos agregados se insertarán aquí -->
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</section>

<script>
  function actualizarPrecio() {
    var articulo = document.getElementById('articulo');
    var precio = articulo.selectedOptions[0].dataset.precio;
    document.getElementById('precio').value = precio;
    calcularTotal();
  }

  function calcularTotal() {
    var cantidad = document.getElementById('cantidad').value;
    var precio = document.getElementById('precio').value;
    var descuento = document.getElementById('descuento').value;
    var subtotal = cantidad * precio;
    var total = subtotal - descuento;
    var impuesto = subtotal * 0.10; // Suponiendo que el impuesto es el 10% del subtotal

    document.getElementById('impuesto').value = impuesto.toFixed(2);
    document.getElementById('total').value = (total + impuesto).toFixed(2);
  }

  function agregarPedido() {
    var articulo = document.getElementById('articulo').selectedOptions[0].text;
    var cantidad = document.getElementById('cantidad').value;
    var precio = document.getElementById('precio').value;
    var subtotal = cantidad * precio;

    var row = `<tr>
                 <td class="px-4 py-2 border">${articulo}</td>
                 <td class="px-4 py-2 border">${cantidad}</td>
                 <td class="px-4 py-2 border">${precio}</td>
                 <td class="px-4 py-2 border subtotal">${subtotal.toFixed(2)}</td>
               </tr>`;
    document.getElementById('detallesPedido').insertAdjacentHTML('beforeend', row);
    calcularImpuestoTotal();
  }

  function calcularImpuestoTotal() {
    var subtotales = document.querySelectorAll('#detallesPedido tr td.subtotal');
    var total = 0;
    var descuentoTotal = 0;

    subtotales.forEach(function (subtotal) {
      total += parseFloat(subtotal.textContent);
    });

    descuentoTotal = parseFloat(document.getElementById('descuento').value) || 0;
    var totalConDescuento = total - descuentoTotal;
    var impuesto = totalConDescuento * 0.10; // Suponiendo que el impuesto es el 10% del total con descuento

    document.getElementById('impuesto').value = impuesto.toFixed(2);
    document.getElementById('total').value = (totalConDescuento + impuesto).toFixed(2);
  }

  function filtrarArticulos() {
    var categoriaSeleccionada = document.getElementById('categoria').value;
    var articulos = document.getElementById('articulo').options;

    for (var i = 0; i < articulos.length; i++) {
      if (articulos[i].dataset.categoria == categoriaSeleccionada || categoriaSeleccionada == "") {
        articulos[i].style.display = "block";
      } else {
        articulos[i].style.display = "none";
      }
    }
  }
</script>

<?php include ('../components/footer.php'); ?>