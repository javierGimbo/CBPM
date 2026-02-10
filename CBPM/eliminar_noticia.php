<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php");
  exit();
}

function fail($msg){
  header("Location: admin_noticias.php?err=" . urlencode($msg));
  exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) fail("ID inválido.");

// obtener portada para borrarla
$stmt = $conn->prepare("SELECT portada FROM noticias WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows !== 1) fail("La noticia no existe.");

$portada = $res->fetch_assoc()['portada'] ?? null;

// borrar en BD
$stmt = $conn->prepare("DELETE FROM noticias WHERE id=?");
$stmt->bind_param("i", $id);
if (!$stmt->execute()) fail("No se pudo borrar.");

// borrar portada del disco
if ($portada && str_starts_with($portada, 'media/noticias/')) {
  $abs = __DIR__ . DIRECTORY_SEPARATOR . $portada;
  if (file_exists($abs)) @unlink($abs);
}

header("Location: admin_noticias.php?ok=1");
exit();
