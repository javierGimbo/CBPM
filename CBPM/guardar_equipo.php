<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php");
  exit();
}

function fail($msg){
  header("Location: admin_equipos.php?err=" . urlencode($msg));
  exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$slug   = trim($_POST['slug'] ?? '');

if ($nombre === '' || $slug === '') {
  fail("Nombre y slug son obligatorios.");
}

$slug = strtolower($slug);
$slug = preg_replace('/\s+/', '-', $slug);         // espacios -> guion
$slug = preg_replace('/[^a-z0-9_-]/', '', $slug);  // limpieza final

if ($slug === '') fail("Slug inválido.");

$stmt = $conn->prepare("INSERT INTO equipos (slug, nombre) VALUES (?,?)");
$stmt->bind_param("ss", $slug, $nombre);

if (!$stmt->execute()) {
  fail("No se pudo crear. ¿Ese slug ya existe?");
}

header("Location: admin_equipos.php?ok=1");
exit();
