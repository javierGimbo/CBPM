<?php
session_start();
include 'conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  http_response_code(403);
  echo json_encode(['ok' => false, 'error' => 'Acceso denegado']);
  exit();
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data) || !isset($data['ids']) || !is_array($data['ids'])) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Datos inválidos']);
  exit();
}

$ids = array_values(array_filter($data['ids'], fn($v) => is_int($v) || ctype_digit((string)$v)));
$ids = array_map('intval', $ids);

if (count($ids) === 0) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Lista vacía']);
  exit();
}

$conn->begin_transaction();

try {
  $stmt = $conn->prepare("UPDATE equipos SET orden = ? WHERE id = ?");

  // Guardamos 1,2,3... según el orden visual
  $orden = 1;
  foreach ($ids as $id) {
    $stmt->bind_param("ii", $orden, $id);
    if (!$stmt->execute()) {
      throw new Exception("No se pudo actualizar el equipo $id");
    }
    $orden++;
  }

  $conn->commit();
  echo json_encode(['ok' => true]);
} catch (Throwable $e) {
  $conn->rollback();
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
