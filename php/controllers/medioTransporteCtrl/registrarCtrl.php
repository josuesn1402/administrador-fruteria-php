<?php
include '../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $tipo = htmlspecialchars($_POST['tipo']);
  $capacidad = htmlspecialchars($_POST['capacidad']);

  $sql = "INSERT INTO medio_transporte (tipo, capacidad) VALUES (?, ?)";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $tipo, $capacidad);
    if ($stmt->execute()) {
      header("Location: ../../views/administrar-medio-transporte.php?message=Medio de transporte registrado con éxito");
      exit();
    } else {
      echo "Error al registrar el medio de transporte: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error al preparar la consulta: " . $conn->error;
  }
  $conn->close();
}
?>
