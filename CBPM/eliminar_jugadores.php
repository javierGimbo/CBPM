<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header("Location: login.php");
  exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  header("Location: admin_jugadores.php?err=" . urlencode("ID inválido"));
  exit();
}

// borrar foto (si existe)
$stmt = $conn->prepare("SELECT foto FROM jugadores WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 1) {
  $foto = $res->fetch_assoc()['foto'] ?? null;
  if ($foto && str_starts_with($foto, 'media/jugadores/')) {
    $abs = __DIR__ . DIRECTORY_SEPARATOR . $foto;
    if (file_exists($abs)) @unlink($abs);
  }
}

$stmt = $conn->prepare("DELETE FROM jugadores WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_jugadores.php?ok=1");
exit();
