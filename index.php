<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username'])) {
  // Si está autenticado, redirigir al dashboard
  header("Location: php/layout/dashboard.php");
  exit;
} else {
  // Si no está autenticado, redirigir a la página de inicio de sesión
  header("Location: php/layout/login.php");
  exit;
}
?>