<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  if (isset($data['productoId']) && isset($data['cantidad'])) {
    $productoId = $data['productoId'];
    $cantidad = $data['cantidad'];

    // Buscar si el producto ya está en la sesión
    $productoExistente = false;
    foreach ($_SESSION['productos'] as &$producto) {
      if ($producto[0] == $productoId) {
        $producto[1] += $cantidad;
        $productoExistente = true;
        break;
      }
    }

    // Si el producto no está en la sesión, agregarlo
    if (!$productoExistente) {
      $_SESSION['productos'][] = [$productoId, $cantidad];
    }

    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
