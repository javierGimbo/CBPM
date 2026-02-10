<?php
session_start();

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  http_response_code(403);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'No autorizado']);
  exit();
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'No se recibió imagen']);
  exit();
}

$maxBytes = 3 * 1024 * 1024; // 3MB
if ($_FILES['file']['size'] > $maxBytes) {
  http_response_code(400);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Imagen supera 3MB']);
  exit();
}

$tmp = $_FILES['file']['tmp_name'];
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($tmp);

$ext = match($mime) {
  'image/jpeg' => 'jpg',
  'image/png'  => 'png',
  'image/webp' => 'webp',
  default => null
};

if ($ext === null) {
  http_response_code(400);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Formato no permitido (JPG/PNG/WEBP)']);
  exit();
}

$dirRel = 'media/noticias';
$dirAbs = __DIR__ . DIRECTORY_SEPARATOR . $dirRel;

if (!is_dir($dirAbs)) {
  mkdir($dirAbs, 0775, true);
}

$filename = 'news_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
$destAbs = $dirAbs . DIRECTORY_SEPARATOR . $filename;
$destRel = $dirRel . '/' . $filename;

if (!move_uploaded_file($tmp, $destAbs)) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'No se pudo guardar la imagen']);
  exit();
}

// TinyMCE necesita "location"
header('Content-Type: application/json');
echo json_encode(['location' => $destRel]);
