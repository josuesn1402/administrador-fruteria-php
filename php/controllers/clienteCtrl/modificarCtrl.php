<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $idCliente = intval($_POST['id']);
  $nombre = htmlspecialchars($_POST['nombre']);
  $direccion = htmlspecialchars($_POST['direccion']);
  $telefono = htmlspecialchars($_POST['telefono']);
  $email = htmlspecialchars($_POST['email']);
  $tipo = htmlspecialchars($_POST['tipo']);

  $sql = "UPDATE cliente SET nombre = ?, direccion = ?, telefono = ?, email = ?, tipo = ? WHERE cliente_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssssi", $nombre, $direccion, $telefono, $email, $tipo, $idCliente);
    if ($stmt->execute()) {
      header("Location: ../../layout/administrar-clientes.php");
      exit();
    } else {
      echo "Error al modificar el cliente: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
