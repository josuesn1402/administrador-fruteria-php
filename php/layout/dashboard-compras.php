<?php
include ('../config/connection.php');
include ('../config/session_check.php');
include ('../components/head.php');
include ('../components/sidebar.php');

// Consulta de proveedores
$queryProveedores = "SELECT idpersona, nombre FROM persona WHERE tipo_persona = 'Proveedor'";
$resultProveedores = mysqli_query($conn, $queryProveedores);

// Consulta de artículos
$queryArticulos = "SELECT idarticulo, idcategoria, codigo, nombre FROM articulo";
$resultArticulos = mysqli_query($conn, $queryArticulos);

// Consulta de categoría
$queryCategorias = "SELECT idcategoria, nombre FROM categoria";
$resultCategorias = mysqli_query($conn, $queryCategorias);
?>

<section class="p-8">
  <div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6">Formulario de Compras</h2>
    <form id="compraForm" method="POST" action="../controllers/ingresosCtrl/registrarCtrl.php" class="grid gap-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col">
          <label for="proveedor" class="mb-2">Proveedor:</label>
          <select id="proveedor" name="proveedor" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php while ($row = mysqli_fetch_assoc($resultProveedores)): ?>
              <option value="<?php echo $row['idpersona']; ?>"><?php echo $row['nombre']; ?></option>
            <?php endwhile; ?>
          </select>
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
          <select id="articulo" name="articulo" class="p-2 border rounded-lg">
            <option value="">Seleccionar</option>
            <?php while ($row = mysqli_fetch_assoc($resultArticulos)): ?>
              <option value="<?php echo $row['idarticulo']; ?>" data-categoria="<?php echo $row['idcategoria']; ?>">
                <?php echo $row['nombre']; ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="flex flex-col">
          <label for="cantidad" class="mb-2">Cantidad:</label>
          <input type="number" id="cantidad" name="cantidad" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="precio_compra" class="mb-2">Precio de Compra:</label>
          <input type="number" step="0.01" id="precio_compra" name="precio_compra" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="precio_venta" class="mb-2">Precio de Venta:</label>
          <input type="number" step="0.01" id="precio_venta" name="precio_venta" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="descuento" class="mb-2">Descuento:</label>
          <input type="number" step="0.01" id="descuento" name="descuento" class="p-2 border rounded-lg">
        </div>
        <div class="flex flex-col">
          <label for="fecha" class="mb-2">Fecha:</label>
          <input type="date" id="fecha" name="fecha" class="p-2 border rounded-lg" value="<?php echo date('Y-m-d'); ?>">
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
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Registrar Compra</button>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-bold mb-4">Detalles del Pedido</h3>
          <table class="min-w-full bg-white border">
            <thead>
              <tr>
                <th class="px-4 py-2 border">Artículo</th>
                <th class="px-4 py-2 border">Cantidad</th>
                <th class="px-4 py-2 border">Precio Compra</th>
                <th class="px-4 py-2 border">Precio Venta</th>
                <th class="px-4 py-2 border">Descuento</th>
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
  function calcularTotal() {
    var cantidad = document.getElementById('cantidad').value;
    var precioCompra = document.getElementById('precio_compra').value;
    var descuento = document.getElementById('descuento').value;
    var total = (cantidad * precioCompra) - descuento;
    document.getElementById('total').value = total.toFixed(2);
  }

  function filtrarArticulos() {
    var categoriaSeleccionada = document.getElementById('categoria').value;
    var articulos = document.getElementById('articulo').options;

    for (var i = 0; i < articulos.length; i++) {
      if (categoriaSeleccionada === "" || articulos[i].dataset.categoria === categoriaSeleccionada) {
        articulos[i].style.display = "";
      } else {
        articulos[i].style.display = "none";
      }
    }
  }

  function agregarPedido() {
    var articulo = document.getElementById('articulo').selectedOptions[0].text;
    var cantidad = document.getElementById('cantidad').value;
    var precioCompra = document.getElementById('precio_compra').value;
    var precioVenta = document.getElementById('precio_venta').value;
    var descuento = document.getElementById('descuento').value;
    var subtotal = (cantidad * precioCompra) - descuento;

    var row = `<tr>
                 <td class="px-4 py-2 border">${articulo}</td>
                 <td class="px-4 py-2 border">${cantidad}</td>
                 <td class="px-4 py-2 border">${precioCompra}</td>
                 <td class="px-4 py-2 border">${precioVenta}</td>
                 <td class="px-4 py-2 border">${descuento}</td>
                 <td class="px-4 py-2 border">${subtotal.toFixed(2)}</td>
               </tr>`;
    document.getElementById('detallesPedido').insertAdjacentHTML('beforeend', row);
    calcularImpuestoTotal();
  }

  function calcularImpuestoTotal() {
    var subtotales = document.querySelectorAll('#detallesPedido tr td:nth-child(6)');
    var total = 0;

    subtotales.forEach(function (subtotal) {
      total += parseFloat(subtotal.textContent);
    });

    // Suponiendo que el impuesto es el 10% del total
    var impuesto = total * 0.10;
    document.getElementById('total').value = (total + impuesto).toFixed(2);
  }
</script>

<?php include ('../components/footer.php'); ?>