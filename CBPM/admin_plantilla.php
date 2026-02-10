<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) { header("Location: login.php"); exit(); }
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') { die("Acceso denegado."); }

$slug = $_GET['equipo'] ?? '';
$stmt = $conn->prepare("SELECT * FROM equipos WHERE slug=?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$equipoRes = $stmt->get_result();
if ($equipoRes->num_rows !== 1) die("Equipo no existe.");
$equipo = $equipoRes->fetch_assoc();
$equipo_id = (int)$equipo['id'];

/* Plantilla del equipo */
$stmt = $conn->prepare("
  SELECT p.id AS plantilla_id, p.dorsal, p.posicion,
         j.id AS jugador_id, j.nombre, j.apellidos, j.foto
  FROM plantilla p
  JOIN jugadores j ON j.id = p.jugador_id
  WHERE p.equipo_id = ?
  ORDER BY j.apellidos, j.nombre
");
$stmt->bind_param("i", $equipo_id);
$stmt->execute();
$plantilla = $stmt->get_result();

/* Jugadores disponibles (no están en esta plantilla) */
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
    <!-- Añadir jugador -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">Añadir jugador a <?php echo htmlspecialchars($equipo['nombre']); ?></div>
        <div class="card-body">
          <form method="POST" action="plantilla_add.php">
            <input type="hidden" name="equipo_id" value="<?php echo $equipo_id; ?>">

            <div class="mb-2">
              <label class="form-label">Jugador</label>
              <select class="form-select" name="jugador_id" required>
                <option value="">-- Selecciona --</option>
                <?php while($j = $disponibles->fetch_assoc()): ?>
                  <option value="<?php echo (int)$j['id']; ?>">
                    <?php echo htmlspecialchars($j['apellidos'].", ".$j['nombre']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="mb-2">
              <label class="form-label">Dorsal (opcional)</label>
              <input type="number" class="form-control" name="dorsal" min="0" max="99">
            </div>

            <div class="mb-3">
              <label class="form-label">Posición (opcional)</label>
              <input type="text" class="form-control" name="posicion" maxlength="30">
            </div>

            <button class="btn btn-primary w-100" type="submit">Añadir</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Lista plantilla -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">Jugadores en plantilla</div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
              <thead>
                <tr>
                  <th style="width:70px;">Foto</th>
                  <th>Jugador</th>
                  <th style="width:80px;">Dorsal</th>
                  <th style="width:140px;">Posición</th>
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
                    <td><?php echo htmlspecialchars((string)$r['dorsal']); ?></td>
                    <td><?php echo htmlspecialchars((string)$r['posicion']); ?></td>
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
