<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) { header("Location: login.php"); exit(); }
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') { die("Acceso denegado."); }

function go($slug, $qs) {
  header("Location: admin_plantilla.php?equipo=" . urlencode($slug) . $qs);
  exit();
}

$slug = $_GET['equipo'] ?? '';
$stmt = $conn->prepare("SELECT * FROM equipos WHERE slug=?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$equipoRes = $stmt->get_result();
if ($equipoRes->num_rows !== 1) die("Equipo no existe.");
$equipo = $equipoRes->fetch_assoc();
$equipo_id = (int)$equipo['id'];

/* =========================
   GUARDAR (POST) aquí mismo
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $jugador_id = (int)($_POST['jugador_id'] ?? 0);
  $rol = $_POST['rol'] ?? 'jugador';

  if (!in_array($rol, ['jugador','entrenador'], true)) {
    go($slug, "&err=" . urlencode("Rol inválido."));
  }

  $dorsal = null;
  if ($rol === 'jugador') {
    $d = trim($_POST['dorsal'] ?? '');
    $dorsal = ($d !== '') ? (int)$d : null; // dorsal opcional
  }

  if ($jugador_id <= 0) {
    go($slug, "&err=" . urlencode("Persona inválida."));
  }

  // Evitar duplicados en el mismo equipo
  $stmt = $conn->prepare("SELECT id FROM plantilla WHERE equipo_id=? AND jugador_id=? LIMIT 1");
  $stmt->bind_param("ii", $equipo_id, $jugador_id);
  $stmt->execute();
  $dup = $stmt->get_result();
  if ($dup->num_rows > 0) {
    go($slug, "&err=" . urlencode("Esa persona ya está en la plantilla."));
  }

  // Insertar
  $stmt = $conn->prepare("INSERT INTO plantilla (equipo_id, jugador_id, dorsal, rol) VALUES (?,?,?,?)");
  $stmt->bind_param("iiis", $equipo_id, $jugador_id, $dorsal, $rol);

  if ($stmt->execute()) {
    go($slug, "&ok=1");
  } else {
    go($slug, "&err=" . urlencode("No se pudo añadir a la plantilla."));
  }
}

/* =========================
   Plantilla del equipo
========================= */
$stmt = $conn->prepare("
  SELECT p.id AS plantilla_id, p.dorsal, p.rol,
         j.id AS jugador_id, j.nombre, j.apellidos, j.foto
  FROM plantilla p
  JOIN jugadores j ON j.id = p.jugador_id
  WHERE p.equipo_id = ?
  ORDER BY p.rol DESC, j.apellidos, j.nombre
");
$stmt->bind_param("i", $equipo_id);
$stmt->execute();
$plantilla = $stmt->get_result();

/* =========================
   Personas disponibles
========================= */
$stmt = $conn->prepare("
  SELECT j.id, j.nombre, j.apellidos
  FROM jugadores j
  WHERE j.id NOT IN (SELECT jugador_id FROM plantilla WHERE equipo_id = ?)
  ORDER BY j.apellidos, j.nombre
");
$stmt->bind_param("i", $equipo_id);
$stmt->execute();
$disponibles = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin - Plantilla <?php echo htmlspecialchars($equipo['nombre']); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Plantilla: <?php echo htmlspecialchars($equipo['nombre']); ?></h2>
    <div>
      <a href="admin_equipos.php" class="btn btn-outline-secondary btn-sm">Volver a equipos</a>
      <a href="admin_jugadores.php" class="btn btn-outline-primary btn-sm">Gestionar jugadores</a>
    </div>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Operación realizada.</div>
  <?php endif; ?>
  <?php if (isset($_GET['err'])): ?>
    <div class="alert alert-danger">Error: <?php echo htmlspecialchars($_GET['err']); ?></div>
  <?php endif; ?>

  <div class="row g-4">
    <!-- Añadir -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">Añadir a <?php echo htmlspecialchars($equipo['nombre']); ?></div>
        <div class="card-body">

          <?php if ($disponibles->num_rows === 0): ?>
            <p class="text-muted mb-0">No hay más personas disponibles para añadir.</p>
          <?php else: ?>
            <form method="POST">
              <div class="mb-2">
                <label class="form-label">Persona</label>
                <select name="jugador_id" class="form-select" required>
                  <?php while($j = $disponibles->fetch_assoc()): ?>
                    <option value="<?php echo (int)$j['id']; ?>">
                      <?php echo htmlspecialchars($j['apellidos'] . ", " . $j['nombre']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>

              <div class="mb-2">
                <label class="form-label">Rol en el equipo</label>
                <select name="rol" id="rol" class="form-select" required>
                  <option value="jugador">Jugador</option>
                  <option value="entrenador">Entrenador</option>
                </select>
              </div>

              <div class="mb-3" id="bloqueDorsal">
                <label class="form-label">Dorsal (solo jugadores)</label>
                <input type="number" name="dorsal" class="form-control" min="0">
              </div>

              <button class="btn btn-primary w-100" type="submit">Añadir a plantilla</button>
            </form>

            <script>
              const rol = document.getElementById('rol');
              const bloqueDorsal = document.getElementById('bloqueDorsal');

              function toggleDorsal(){
                if(rol.value === 'entrenador'){
                  bloqueDorsal.style.display = 'none';
                }else{
                  bloqueDorsal.style.display = 'block';
                }
              }
              rol.addEventListener('change', toggleDorsal);
              toggleDorsal();
            </script>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <!-- Lista -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">Plantilla</div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
              <thead>
                <tr>
                  <th style="width:70px;">Foto</th>
                  <th>Persona</th>
                  <th style="width:120px;">Rol</th>
                  <th style="width:90px;">Dorsal</th>
                  <th style="width:120px;">Acción</th>
                </tr>
              </thead>
              <tbody>
                <?php while($r = $plantilla->fetch_assoc()): ?>
                  <tr>
                    <td>
                      <?php if (!empty($r['foto'])): ?>
                        <img src="<?php echo htmlspecialchars($r['foto']); ?>"
                             style="width:56px; height:56px; object-fit:cover; border-radius:8px;">
                      <?php else: ?>
                        <span class="text-muted">—</span>
                      <?php endif; ?>
                    </td>

                    <td><strong><?php echo htmlspecialchars($r['apellidos'].", ".$r['nombre']); ?></strong></td>

                    <td><?php echo htmlspecialchars($r['rol']); ?></td>

                    <td><?php echo $r['rol'] === 'jugador' ? htmlspecialchars((string)$r['dorsal']) : "—"; ?></td>

                    <td>
                      <a class="btn btn-sm btn-outline-danger"
                         href="plantilla_remove.php?id=<?php echo (int)$r['plantilla_id']; ?>&equipo=<?php echo htmlspecialchars($slug); ?>"
                         onclick="return confirm('¿Quitar de la plantilla?');">
                        Quitar
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
