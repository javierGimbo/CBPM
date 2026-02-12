<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) { header("Location: login.php"); exit(); }
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') { die("Acceso denegado."); }

$equipos = $conn->query("SELECT * FROM equipos ORDER BY orden ASC, nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin - Equipos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .drag-handle { cursor: grab; user-select:none; }
    .sortable-ghost { opacity: .4; }
    .sortable-chosen { background: #f8f9fa; }
  </style>
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Gestionar Equipos</h2>
    <div>
      <a href="admin_web.php" class="btn btn-outline-secondary btn-sm">Volver</a>
      <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Equipo creado.</div>
  <?php endif; ?>
  <?php if (isset($_GET['err'])): ?>
    <div class="alert alert-danger">Error: <?php echo htmlspecialchars($_GET['err']); ?></div>
  <?php endif; ?>

  <div id="saveMsg" class="alert alert-success d-none">Orden guardado ✅</div>
  <div id="saveErr" class="alert alert-danger d-none">No se pudo guardar el orden ❌</div>

  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">Crear equipo nuevo</div>
        <div class="card-body">
          <form method="POST" action="guardar_equipo.php">
            <div class="mb-2">
              <label class="form-label">Nombre (visible)</label>
              <input class="form-control" type="text" name="nombre" required>
            </div>

            <div class="mb-2">
              <label class="form-label">Slug (para URL)</label>
              <input class="form-control" type="text" name="slug" required>
              <div class="form-text">Ej: <code>minibasket</code> (sin espacios)</div>
            </div>


            <button class="btn btn-primary w-100" type="submit">Crear</button>
          </form>
        </div>
      </div>

    
    </div>

    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">Equipos (arrastrar para ordenar)</div>
        <div class="card-body p-0">
          <div class="list-group list-group-flush" id="equiposList">
            <?php while($e = $equipos->fetch_assoc()): ?>
              <div class="list-group-item d-flex justify-content-between align-items-center"
                   data-id="<?php echo (int)$e['id']; ?>">
                <div class="d-flex align-items-center gap-2">
                  <span class="drag-handle text-muted">☰</span>
                  <div>
                    <strong><?php echo htmlspecialchars($e['nombre']); ?></strong>
                    <div class="text-muted" style="font-size:0.85rem;">
                      slug: <?php echo htmlspecialchars($e['slug']); ?>
                    </div>
                  </div>
                </div>

                <div class="d-flex gap-2">
                  <a class="btn btn-sm btn-outline-primary"
                     href="admin_plantilla.php?equipo=<?php echo htmlspecialchars($e['slug']); ?>">
                    Gestionar plantilla
                  </a>

                  <a class="btn btn-sm btn-outline-danger"
                     href="eliminar_equipo.php?id=<?php echo (int)$e['id']; ?>"
                     onclick="return confirm('¿Seguro que quieres borrar este equipo? Se borrará también su plantilla.');">
                    Borrar
                  </a>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
  const list = document.getElementById('equiposList');
  const saveMsg = document.getElementById('saveMsg');
  const saveErr = document.getElementById('saveErr');

  function flash(el){
    el.classList.remove('d-none');
    setTimeout(() => el.classList.add('d-none'), 1800);
  }

  const sortable = new Sortable(list, {
    animation: 150,
    handle: '.drag-handle',
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onEnd: async () => {
      const ids = Array.from(list.querySelectorAll('[data-id]')).map(el => parseInt(el.dataset.id, 10));

      try{
        const res = await fetch('guardar_orden_equipos.php', {
          method: 'POST',
          headers: {'Content-Type':'application/json'},
          body: JSON.stringify({ ids })
        });

        if(!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();
        if(!data.ok) throw new Error(data.error || 'fail');

        flash(saveMsg);
      }catch(e){
        console.error(e);
        flash(saveErr);
      }
    }
  });
</script>
</body>
</html>
