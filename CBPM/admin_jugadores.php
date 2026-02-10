<?php
session_start();
include 'conexion.php';

// Protección básica
if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  die("Acceso denegado.");
}

// Si viene ?edit=ID cargamos datos para editar
$editando = false;
$jugador = [
  'id' => '',
  'nombre' => '',
  'apellidos' => '',
  'sexo' => 'X',
  'fecha_nacimiento' => '',
  'foto' => null
];

if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $stmt = $conn->prepare("SELECT * FROM jugadores WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows === 1) {
    $jugador = $res->fetch_assoc();
    $editando = true;
  }
}

// Listado
$list = $conn->query("SELECT * FROM jugadores ORDER BY apellidos, nombre");

// Leer catálogo de fotos
$catalogoDirAbs = __DIR__ . '/media/jugadores/defaults';
$catalogoFiles = [];
if (is_dir($catalogoDirAbs)) {
  $catalogoFiles = array_values(array_filter(scandir($catalogoDirAbs), function($f){
    if ($f === '.' || $f === '..') return false;
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    return in_array($ext, ['png','jpg','jpeg','webp'], true);
  }));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Jugadores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Panel de Jugadores</h2>
    <div>
      <a class="btn btn-outline-secondary btn-sm" href="admin_web.php">Volver al Admin</a>
      <a class="btn btn-outline-danger btn-sm" href="logout.php">Salir</a>
    </div>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Guardado correctamente.</div>
  <?php endif; ?>
  <?php if (isset($_GET['err'])): ?>
    <div class="alert alert-danger">
      Error: <?php echo htmlspecialchars($_GET['err']); ?>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">
          <?php echo $editando ? "Editar jugador" : "Crear jugador"; ?>
        </div>
        <div class="card-body">

          <!-- OJO: tu archivo es guardar_jugadores.php (plural) -->
          <form action="guardar_jugadores.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($jugador['id']); ?>">

            <div class="mb-2">
              <label class="form-label">Nombre</label>
              <input class="form-control" type="text" name="nombre" required
                     value="<?php echo htmlspecialchars($jugador['nombre'] ?? ''); ?>">
            </div>

            <div class="mb-2">
              <label class="form-label">Apellidos</label>
              <input class="form-control" type="text" name="apellidos" required
                     value="<?php echo htmlspecialchars($jugador['apellidos'] ?? ''); ?>">
            </div>

            <div class="mb-2">
              <label class="form-label">Sexo</label>
              <select class="form-select" name="sexo" required>
                <option value="M" <?php if(($jugador['sexo'] ?? 'X')==='M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if(($jugador['sexo'] ?? 'X')==='F') echo 'selected'; ?>>Femenino</option>
                <option value="X" <?php if(($jugador['sexo'] ?? 'X')==='X') echo 'selected'; ?>>Otro / No indica</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Fecha de nacimiento</label>
              <input class="form-control" type="date" name="fecha_nacimiento" required
                     value="<?php echo htmlspecialchars($jugador['fecha_nacimiento'] ?? ''); ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Foto (subir) (jpg/png/webp)</label>
              <input class="form-control" type="file" name="foto"
                     accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
              <div class="form-text">Si subes una foto, tendrá prioridad sobre la selección de catálogo.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">O elegir foto del catálogo</label>
              <select class="form-select" name="foto_catalogo">
                <option value="">-- No elegir --</option>
                <?php
                  foreach ($catalogoFiles as $f) {
                    $pathRel = 'media/jugadores/defaults/' . $f;
                    $selected = (!empty($jugador['foto']) && $jugador['foto'] === $pathRel) ? 'selected' : '';
                    echo "<option value='".htmlspecialchars($pathRel)."' $selected>".htmlspecialchars($f)."</option>";
                  }
                ?>
              </select>
              <div class="form-text">Mete imágenes en <code>media/jugadores/defaults/</code> y aparecerán aquí.</div>
            </div>

            <?php if ($editando && !empty($jugador['foto'])): ?>
              <div class="mb-3">
                <small class="text-muted d-block mb-1">Foto actual:</small>
                <img src="<?php echo htmlspecialchars($jugador['foto']); ?>" alt="Foto jugador"
                     style="max-width:140px; height:auto; border-radius:8px; border:1px solid #ddd;">
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" name="borrar_foto" id="borrar_foto">
                  <label class="form-check-label" for="borrar_foto">Quitar foto</label>
                </div>
              </div>
            <?php endif; ?>

            <button class="btn btn-primary w-100" type="submit">
              <?php echo $editando ? "Guardar cambios" : "Crear jugador"; ?>
            </button>

            <?php if ($editando): ?>
              <a class="btn btn-outline-secondary w-100 mt-2" href="admin_jugadores.php">Cancelar edición</a>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">Listado</div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
              <thead>
                <tr>
                  <th style="width:80px;">Foto</th>
                  <th>Jugador</th>
                  <th>Sexo</th>
                  <th>Fecha Nac.</th>
                  <th style="width:160px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php while($r = $list->fetch_assoc()): ?>
                <tr>
                  <td>
                    <?php if (!empty($r['foto'])): ?>
                      <img src="<?php echo htmlspecialchars($r['foto']); ?>" alt="foto"
                           style="width:56px; height:56px; object-fit:cover; border-radius:8px;">
                    <?php else: ?>
                      <span class="text-muted">—</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <strong><?php echo htmlspecialchars(($r['apellidos'] ?? '') . ", " . ($r['nombre'] ?? '')); ?></strong>
                  </td>
                  <td><?php echo htmlspecialchars($r['sexo'] ?? ''); ?></td>
                  <td>
                    <?php
                      if (!empty($r['fecha_nacimiento'])) {
                        echo htmlspecialchars(date("d/m/Y", strtotime($r['fecha_nacimiento'])));
                      } else {
                        echo "<span class='text-muted'>—</span>";
                      }
                    ?>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="admin_jugadores.php?edit=<?php echo (int)$r['id']; ?>">Editar</a>
                    <a class="btn btn-sm btn-outline-danger"
                       href="eliminar_jugador.php?id=<?php echo (int)$r['id']; ?>"
                       onclick="return confirm('¿Seguro que quieres borrar este jugador?');">
                      Borrar
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

</body>
</html>
