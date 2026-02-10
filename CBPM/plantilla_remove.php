<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php"); exit();
}

$id = (int)($_GET['id'] ?? 0);
$slug = $_GET['equipo'] ?? '';

if ($id > 0) {
  $stmt = $conn->prepare("DELETE FROM plantilla WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

header("Location: admin_plantilla.php?equipo=".urlencode($slug)."&ok=1");
exit();
