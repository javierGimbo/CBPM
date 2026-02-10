<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  die("Acceso denegado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Panel de Administración</h2>
    <div class="d-flex gap-2">
      <a href="admin_jugadores.php" class="btn btn-outline-primary btn-sm">Gestionar Jugadores</a>
      <a href="admin_equipos.php" class="btn btn-outline-primary btn-sm">Gestionar equipos / plantillas</a>
      <a href="admin_noticias.php" class="btn btn-outline-primary btn-sm">Gestionar Noticias</a>
      <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Acción realizada con éxito ✅</div>
  <?php endif; ?>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span>Crear noticia rápida</span>
      <a href="admin_noticias.php" class="btn btn-sm btn-outline-secondary">Ir al gestor completo</a>
    </div>

    <div class="card-body">

      <form action="guardar_noticia.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="0">

        <div class="mb-3">
          <label class="form-label">Título</label>
          <input class="form-control" type="text" name="titulo" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Encabezado</label>
          <input class="form-control" type="text" name="encabezado" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Imagen de portada</label>
          <input class="form-control"
                 type="file"
                 name="portada"
                 accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
          <small class="text-muted">
            Imagen principal que se verá en el inicio y dentro de la noticia
          </small>
        </div>

        <div class="mb-3">
          <label class="form-label">Cuerpo de la noticia</label>
          <textarea id="cuerpo" class="form-control" name="cuerpo" rows="12"></textarea>
          <div class="form-text">
            Consejo: usa <b>H2/H3</b> para cada crónica/partido y añade imágenes entre secciones.
          </div>
        </div>

        <button class="btn btn-primary" type="submit">Guardar Noticia</button>
      </form>

    </div>
  </div>

</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/xxlcyxg9yyxyjalizosj10gq6uahn8ryks8zpx4ut0jkh2ts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#cuerpo',
    height: 420,
    menubar: true,
    plugins: 'lists link image table code preview autoresize',
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code preview',
    automatic_uploads: true,
    images_upload_url: 'subir_imagen_noticia.php',
    images_reuse_filename: true
  });
</script>

</body>
</html>
