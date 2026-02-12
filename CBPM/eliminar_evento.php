<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php");
  exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  header("Location: admin_eventos.php?err=" . urlencode("ID inválido."));
  exit();
}

$stmt = $conn->prepare("DELETE FROM eventos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_eventos.php?ok=1");
exit();
