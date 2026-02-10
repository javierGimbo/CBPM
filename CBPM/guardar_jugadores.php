<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header("Location: login.php");
  exit();
}

function fail($msg) {
  header("Location: admin_jugadores.php?err=" . urlencode($msg));
  exit();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$sexo = $_POST['sexo'] ?? 'X';

// ✅ NUEVO: fecha completa
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
$dt = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
if (!$dt || $dt->format('Y-m-d') !== $fecha_nacimiento) {
  fail("Fecha de nacimiento inválida.");
}

// ✅ NUEVO: foto catálogo (ruta relativa)
$foto_catalogo = trim($_POST['foto_catalogo'] ?? '');

// Validación básica
if ($nombre === '' || $apellidos === '' || !in_array($sexo, ['M','F','X'], true)) {
  fail("Datos inválidos.");
}

// Obtener foto actual si editamos
$fotoActual = null;
if ($id > 0) {
  $stmt = $conn->prepare("SELECT foto FROM jugadores WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows !== 1) fail("Jugador no existe.");
  $fotoActual = $res->fetch_assoc()['foto'] ?? null;
}

// Helpers
function esFotoCatalogo($ruta) {
  return is_string($ruta) && str_starts_with($ruta, 'media/jugadores/defaults/');
}
function esFotoSubida($ruta) {
  return is_string($ruta) && str_starts_with($ruta, 'media/jugadores/') && !esFotoCatalogo($ruta);
}

// Si marcaron quitar foto
$borrarFoto = isset($_POST['borrar_foto']) && $_POST['borrar_foto'] === 'on';
$nuevaFotoPath = $fotoActual;

if ($borrarFoto && $fotoActual) {
  // ✅ Solo borrar del disco si era una foto subida (NO catálogo)
  if (esFotoSubida($fotoActual)) {
    $fs = __DIR__ . DIRECTORY_SEPARATOR . $fotoActual;
    if (file_exists($fs)) @unlink($fs);
  }
  $nuevaFotoPath = null;
}

// Subida de nueva foto (si existe) -> tiene prioridad
$subioNuevaFoto = (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE);

if ($subioNuevaFoto) {

  if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    fail("Error subiendo la foto.");
  }

  $maxBytes = 2 * 1024 * 1024; // 2MB
  if ($_FILES['foto']['size'] > $maxBytes) {
    fail("La foto supera 2MB.");
  }

  $tmp = $_FILES['foto']['tmp_name'];
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime = $finfo->file($tmp);

  $ext = match($mime) {
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    default      => null
  };
  if ($ext === null) {
    fail("Formato no permitido. Usa JPG/PNG/WEBP.");
  }

  $dirRel = 'media/jugadores';
  $dirAbs = __DIR__ . DIRECTORY_SEPARATOR . $dirRel;

  if (!is_dir($dirAbs)) {
    if (!mkdir($dirAbs, 0775, true)) fail("No se pudo crear carpeta de imágenes.");
  }

  $filename = 'jug_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
  $destRel = $dirRel . '/' . $filename;
  $destAbs = $dirAbs . DIRECTORY_SEPARATOR . $filename;

  if (!move_uploaded_file($tmp, $destAbs)) {
    fail("No se pudo guardar la foto.");
  }

  // ✅ borrar foto anterior solo si era subida (no catálogo)
  if ($fotoActual && esFotoSubida($fotoActual)) {
    $oldAbs = __DIR__ . DIRECTORY_SEPARATOR . $fotoActual;
    if (file_exists($oldAbs)) @unlink($oldAbs);
  }

  $nuevaFotoPath = $destRel;
}

// Si NO subió foto nueva, pero eligió una del catálogo, usar esa
if (!$subioNuevaFoto && $foto_catalogo !== '') {
  // Seguridad: solo permitir dentro de defaults
  if (!esFotoCatalogo($foto_catalogo)) {
    fail("Foto de catálogo inválida.");
  }

  $abs = __DIR__ . DIRECTORY_SEPARATOR . $foto_catalogo;
  if (!file_exists($abs)) {
    fail("La foto de catálogo no existe.");
  }

  // ✅ si antes había una foto subida, la puedes borrar para no dejar basura
  if ($fotoActual && esFotoSubida($fotoActual)) {
    $oldAbs = __DIR__ . DIRECTORY_SEPARATOR . $fotoActual;
    if (file_exists($oldAbs)) @unlink($oldAbs);
  }

  $nuevaFotoPath = $foto_catalogo;
}

// Guardar en DB
if ($id > 0) {
  $stmt = $conn->prepare("UPDATE jugadores SET nombre=?, apellidos=?, sexo=?, fecha_nacimiento=?, foto=? WHERE id=?");
  $stmt->bind_param("sssssi", $nombre, $apellidos, $sexo, $fecha_nacimiento, $nuevaFotoPath, $id);
  if (!$stmt->execute()) fail("No se pudo actualizar.");
} else {
  $stmt = $conn->prepare("INSERT INTO jugadores (nombre, apellidos, sexo, fecha_nacimiento, foto) VALUES (?,?,?,?,?)");
  $stmt->bind_param("sssss", $nombre, $apellidos, $sexo, $fecha_nacimiento, $nuevaFotoPath);
  if (!$stmt->execute()) fail("No se pudo insertar.");
}

header("Location: admin_jugadores.php?ok=1");
exit();
