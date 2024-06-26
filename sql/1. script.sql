DROP DATABASE IF EXISTS la_frutita;

CREATE DATABASE IF NOT EXISTS la_frutita;

USE la_frutita;

-- Tabla usuario
CREATE TABLE
  usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(100) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    rol VARCHAR(15) NOT NULL -- Administrador y Operador
  );

-- Tabla producto
CREATE TABLE
  producto (
    producto_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo VARCHAR(10) NOT NULL, -- Local y Importado
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
  );

-- Tabla cliente
CREATE TABLE
  cliente (
    cliente_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    tipo VARCHAR(10) NOT NULL -- Local y Provincial
  );

-- Tabla documento
CREATE TABLE
  documento (
    documento_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_documento VARCHAR(50) NOT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha_emision DATE NOT NULL,
    monto DECIMAL(10, 2) NOT NULL
  );

-- Tabla medio_transporte
CREATE TABLE
  medio_transporte (
    medio_transporte_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(10) NOT NULL, -- Camion, Trailer, Avion
    placa VARCHAR(20),
    capacidad INT NOT NULL
  );

-- Tabla transportista
CREATE TABLE
  transportista (
    transportista_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100)
  );

-- Tabla pedido
CREATE TABLE
  pedido (
    pedido_id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_pedido VARCHAR(20) UNIQUE,
    medio_transporte_id INT,
    transportista_id INT,
    fecha_pedido DATE NOT NULL,
    cliente_id INT,
    documento_id INT,
    fecha_salida DATE NOT NULL,
    fecha_llegada DATE NOT NULL,
    estado VARCHAR(15) NOT NULL, -- En Transito y Entregado
    FOREIGN KEY (cliente_id) REFERENCES cliente (cliente_id),
    FOREIGN KEY (documento_id) REFERENCES documento (documento_id),
    FOREIGN KEY (medio_transporte_id) REFERENCES medio_transporte (medio_transporte_id),
    FOREIGN KEY (transportista_id) REFERENCES transportista (transportista_id)
  );

-- Tabla pedido_producto (detalle del pedido)
CREATE TABLE
  pedido_producto (
    pedido_producto_id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    producto_id INT,
    cantidad INT NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedido (pedido_id),
    FOREIGN KEY (producto_id) REFERENCES producto (producto_id)
  );