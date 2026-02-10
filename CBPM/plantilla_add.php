<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php"); exit();
}

$equipo_id = (int)($_POST['equipo_id'] ?? 0);
$jugador_id = (int)($_POST['jugador_id'] ?? 0);
$dorsal = $_POST['dorsal'] ?? null;
$posicion = trim($_POST['posicion'] ?? '');

if ($equipo_id <= 0 || $jugador_id <= 0) {
  header("Location: admin_equipos.php"); exit();
}

$dorsalVal = null;
if ($dorsal !== null && $dorsal !== '') {
  $d = (int)$dorsal;
  if ($d < 0 || $d > 99) { $dorsalVal = null; } else { $dorsalVal = $d; }
}
$posicionVal = ($posicion === '') ? null : $posicion;

$stmt = $conn->prepare("INSERT INTO plantilla (equipo_id, jugador_id, dorsal, posicion) VALUES (?,?,?,?)");
$stmt->bind_param("iiis", $equipo_id, $jugador_id, $dorsalVal, $posicionVal);

if (!$stmt->execute()) {
  // Si ya estaba, saltará por UNIQUE
  header("Location: admin_equipos.php");
  exit();
}

// volver a la plantilla del equipo (sacamos el slug)
$stmt = $conn->prepare("SELECT slug FROM equipos WHERE id=?");
$stmt->bind_param("i", $equipo_id);
$stmt->execute();
$slug = $stmt->get_result()->fetch_assoc()['slug'] ?? '';
header("Location: admin_plantilla.php?equipo=".$slug."&ok=1");
exit();
