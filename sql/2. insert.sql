USE la_frutita;

-- Inserción de datos en la tabla tipo_documento
INSERT INTO tipo_documento (descripcion)
VALUES
  ('Guía de Entrega'),
  ('Guía de Pedido'),
  ('Nota de Pedido'),
  ('Boleta'),
  ('Factura');

-- Inserción de datos en la tabla cliente
INSERT INTO cliente (nombre, direccion, telefono, email, tipo)
VALUES
  ('Cliente 1', 'Direccion 1', '111111111', 'cliente1@correo.com', 'Local'),
  ('Cliente 2', 'Direccion 2', '222222222', 'cliente2@correo.com', 'Provincial'),
  ('Cliente 3', 'Direccion 3', '333333333', 'cliente3@correo.com', 'Local');

-- Inserción de datos en la tabla producto
INSERT INTO producto (nombre, tipo, fecha_ingreso, fecha_caducidad, precio)
VALUES
  ('Manzana', 'Local', '2024-01-01', '2024-01-15', 1.50),
  ('Pera', 'Importado', '2024-01-01', '2024-01-20', 2.00),
  ('Platano', 'Local', '2024-01-05', '2024-01-25', 1.20);

-- Inserción de datos en la tabla documento
INSERT INTO documento (tipo_documento_id, numero, fecha_emision, monto)
VALUES
  (1, 'GE-001', '2024-01-10', 150.00),
  (2, 'GP-001', '2024-01-10', 200.00),
  (3, 'NP-001', '2024-01-11', 250.00);

-- Inserción de datos en la tabla medio_transporte
INSERT INTO medio_transporte (tipo, placa, capacidad)
VALUES
  ('Camion', 'ABC-123', 1000),
  ('Trailer', 'XYZ-456', 2000),
  ('Avion', 'RTZ-787', 500);

-- Inserción de datos en la tabla transportista
INSERT INTO transportista (nombre, telefono, email)
VALUES
  ('Transportista 1', '444444444', 'transportista1@correo.com'),
  ('Transportista 2', '555555555', 'transportista2@correo.com');

-- Inserción de datos en la tabla pedido
INSERT INTO pedido (fecha_pedido, cliente_id, documento_id)
VALUES
  ('2024-01-10', 1, 1),
  ('2024-01-11', 2, 2),
  ('2024-01-12', 3, 3);

-- Inserción de datos en la tabla pedido_producto
INSERT INTO pedido_producto (pedido_id, producto_id, cantidad)
VALUES
  (1, 1, 10),
  (1, 2, 5),
  (2, 1, 15),
  (2, 3, 20),
  (3, 2, 8);

-- Inserción de datos en la tabla usuario
INSERT INTO usuario (nombre_usuario, contrasena, nombre_completo, rol)
VALUES
  ('admin', 'admin123', 'Administrador Principal', 'Administrador'),
  ('operador1', 'operador123', 'Operador Uno', 'Operador');

-- Inserción de datos en la tabla pedido_transportado
INSERT INTO pedido_transportado (pedido_id, medio_transporte_id, transportista_id, fecha_salida, fecha_llegada, estado)
VALUES
  (1, 1, 1, '2024-01-10', '2024-01-12', 'Entregado'),
  (2, 2, 2, '2024-01-11', '2024-01-15', 'En Transito'),
  (3, 3, 1, '2024-01-12', '2024-01-13', 'Entregado');
