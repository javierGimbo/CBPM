<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php");
  exit();
}

$editando = false;
$noticia = [
  'id' => '',
  'titulo' => '',
  'encabezado' => '',
  'portada' => '',
  'cuerpo' => ''
];

if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $stmt = $conn->prepare("SELECT * FROM noticias WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows === 1) {
    $noticia = $res->fetch_assoc();
    $editando = true;
  }
}

$list = $conn->query("SELECT id, titulo, encabezado, portada, fecha FROM noticias ORDER BY fecha DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin - Noticias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Gestionar Noticias</h2>
    <div class="d-flex gap-2">
      <a href="admin_web.php" class="btn btn-outline-secondary btn-sm">Volver</a>
      <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Guardado correctamente ✅</div>
  <?php endif; ?>
  <?php if (isset($_GET['err'])): ?>
    <div class="alert alert-danger">Error: <?php echo htmlspecialchars($_GET['err']); ?></div>
  <?php endif; ?>

  <div class="row g-4">

    <!-- FORM CREAR / EDITAR -->
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">
          <?php echo $editando ? "Editar noticia" : "Crear noticia"; ?>
        </div>
        <div class="card-body">
          <form action="guardar_noticia.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($noticia['id']); ?>">

            <div class="mb-2">
              <label class="form-label">Título</label>
              <input class="form-control" type="text" name="titulo" required
                     value="<?php echo htmlspecialchars($noticia['titulo']); ?>">
            </div>

            <div class="mb-2">
              <label class="form-label">Encabezado (resumen)</label>
              <input class="form-control" type="text" name="encabezado" required
                     value="<?php echo htmlspecialchars($noticia['encabezado']); ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Portada (jpg/png/webp)</label>
              <input class="form-control" type="file" name="portada"
                     accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

              <?php if ($editando && !empty($noticia['portada'])): ?>
                <div class="mt-2">
                  <small class="text-muted d-block mb-1">Portada actual:</small>
                  <img src="<?php echo htmlspecialchars($noticia['portada']); ?>"
                       style="max-width:100%; height:auto; border-radius:10px; border:1px solid #ddd;">
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="borrar_portada" id="borrar_portada">
                    <label class="form-check-label" for="borrar_portada">Quitar portada</label>
                  </div>
                </div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Cuerpo</label>
              <textarea id="cuerpo" class="form-control" name="cuerpo" rows="12"><?php
                echo htmlspecialchars($noticia['cuerpo']);
              ?></textarea>
            </div>

            <button class="btn btn-primary w-100" type="submit">
              <?php echo $editando ? "Guardar cambios" : "Crear noticia"; ?>
            </button>

            <?php if ($editando): ?>
              <a class="btn btn-outline-secondary w-100 mt-2" href="admin_noticias.php">Cancelar edición</a>
            <?php endif; ?>

          </form>
        </div>
      </div>
    </div>

    <!-- LISTADO -->
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">Listado</div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
              <thead>
                <tr>
                  <th style="width:90px;">Portada</th>
                  <th>Noticia</th>
                  <th style="width:140px;">Fecha</th>
                  <th style="width:190px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php while($r = $list->fetch_assoc()): ?>
                <tr>
                  <td>
                    <?php if (!empty($r['portada'])): ?>
                      <img src="<?php echo htmlspecialchars($r['portada']); ?>"
                           style="width:72px; height:52px; object-fit:cover; border-radius:8px;">
                    <?php else: ?>
                      <span class="text-muted">—</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <strong><?php echo htmlspecialchars($r['titulo']); ?></strong><br>
                    <small class="text-muted"><?php echo htmlspecialchars($r['encabezado']); ?></small>
                  </td>
                  <td>
                    <?php
                      echo !empty($r['fecha']) ? htmlspecialchars(date('d/m/Y', strtotime($r['fecha']))) : '—';
                    ?>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary"
                       href="admin_noticias.php?edit=<?php echo (int)$r['id']; ?>">Editar</a>

                    <a class="btn btn-sm btn-outline-danger"
                       href="eliminar_noticia.php?id=<?php echo (int)$r['id']; ?>"
                       onclick="return confirm('¿Seguro que quieres borrar esta noticia?');">
                      Borrar
                    </a>

                    <a class="btn btn-sm btn-outline-secondary"
                       href="noticia.php?id=<?php echo (int)$r['id']; ?>" target="_blank">
                      Ver
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
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
