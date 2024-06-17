<?php
session_start();
include ('../config/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Consulta para verificar las credenciales del usuario y obtener su rol
  $query = "SELECT usuario_id FROM usuario WHERE nombre_usuario = ? AND contrasena = ?";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->bind_result($id_usuario);
      $stmt->fetch();

      // Iniciar la sesión y guardar los datos del usuario
      $_SESSION['user_id'] = $id_usuario;
      $_SESSION['username'] = $username;

      // Redirigir al menú principal
      header("Location: ../layout/dashboard.php");
      exit();
    } else {
      // Credenciales incorrectas
      header("Location: ../../index.php?error=credenciales");
      exit();
    }

    $stmt->close();
  } else {
    // Error en la consulta
    header("Location: ../../index.php?error=credenciales");
    exit();
  }

  $conn->close();
} else {
  // Redirigir si se accede al script directamente
  header("Location: ../../index.php");
  exit();
}
?>