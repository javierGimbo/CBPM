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

$id = (int)($_POST['id'] ?? 0);
$titulo = trim($_POST['titulo'] ?? '');
$encabezado = trim($_POST['encabezado'] ?? '');
$cuerpo = $_POST['cuerpo'] ?? '';

if ($titulo === '' || $encabezado === '' || $cuerpo === '') {
  fail("Faltan datos.");
}

// Foto actual si editamos
$portadaActual = null;
if ($id > 0) {
  $stmt = $conn->prepare("SELECT portada FROM noticias WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows !== 1) fail("La noticia no existe.");
  $portadaActual = $res->fetch_assoc()['portada'] ?? null;
}

$borrarPortada = isset($_POST['borrar_portada']) && $_POST['borrar_portada'] === 'on';
$portadaPath = $portadaActual;

// Quitar portada
if ($borrarPortada && $portadaActual) {
  if (str_starts_with($portadaActual, 'media/noticias/')) {
    $abs = __DIR__ . DIRECTORY_SEPARATOR . $portadaActual;
    if (file_exists($abs)) @unlink($abs);
  }
  $portadaPath = null;
}

// Subir nueva portada (si viene)
if (isset($_FILES['portada']) && $_FILES['portada']['error'] !== UPLOAD_ERR_NO_FILE) {

  if ($_FILES['portada']['error'] !== UPLOAD_ERR_OK) fail("Error subiendo la portada.");

  if ($_FILES['portada']['size'] > 3 * 1024 * 1024) fail("La portada supera 3MB.");

  $tmp = $_FILES['portada']['tmp_name'];
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime = $finfo->file($tmp);

  $ext = match ($mime) {
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    default      => null
  };

  if ($ext === null) fail("Formato no permitido (JPG/PNG/WEBP).");

  $dirRel = 'media/noticias';
  $dirAbs = __DIR__ . DIRECTORY_SEPARATOR . $dirRel;
  if (!is_dir($dirAbs)) mkdir($dirAbs, 0775, true);

  $filename = 'portada_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
  $destRel = $dirRel . '/' . $filename;
  $destAbs = $dirAbs . DIRECTORY_SEPARATOR . $filename;

  if (!move_uploaded_file($tmp, $destAbs)) fail("No se pudo guardar la portada.");

  // borrar portada anterior si existía
  if ($portadaActual && str_starts_with($portadaActual, 'media/noticias/')) {
    $oldAbs = __DIR__ . DIRECTORY_SEPARATOR . $portadaActual;
    if (file_exists($oldAbs)) @unlink($oldAbs);
  }

  $portadaPath = $destRel;
}

// Guardar en DB
if ($id > 0) {
  $stmt = $conn->prepare("UPDATE noticias SET titulo=?, encabezado=?, portada=?, cuerpo=? WHERE id=?");
  $stmt->bind_param("ssssi", $titulo, $encabezado, $portadaPath, $cuerpo, $id);
  if (!$stmt->execute()) fail("No se pudo actualizar.");
} else {
  $stmt = $conn->prepare("INSERT INTO noticias (titulo, encabezado, portada, cuerpo, fecha) VALUES (?,?,?,?,NOW())");
  $stmt->bind_param("ssss", $titulo, $encabezado, $portadaPath, $cuerpo);
  if (!$stmt->execute()) fail("No se pudo crear.");
}

header("Location: admin_noticias.php?ok=1");
exit();
