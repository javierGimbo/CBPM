<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php");
  exit();
}

function backErr($msg){
  header("Location: admin_equipos.php?err=" . urlencode($msg));
  exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) backErr("ID inválido.");

// (Opcional) Evitar borrar equipos “base” por id, si quieres (comenta si no)
// if (in_array($id, [1,2,3,4,5], true)) backErr("No se puede borrar este equipo.");

$conn->begin_transaction();

try {
  // 1) borrar plantilla de ese equipo (para evitar errores por FK)
  $stmt = $conn->prepare("DELETE FROM plantilla WHERE equipo_id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  // 2) borrar el equipo
  $stmt = $conn->prepare("DELETE FROM equipos WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  if ($stmt->affected_rows !== 1) {
    $conn->rollback();
    backErr("No se encontró el equipo o no se pudo borrar.");
  }

  $conn->commit();
  header("Location: admin_equipos.php?ok=Equipo borrado");
  exit();

} catch (Throwable $e) {
  $conn->rollback();
  backErr("Error borrando equipo.");
}
