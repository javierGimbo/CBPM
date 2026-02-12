<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
  header("Location: login.php");
  exit();
}

// Crear evento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titulo = trim($_POST['titulo'] ?? '');
  $fecha = trim($_POST['fecha_inicio'] ?? '');
  $lugar = trim($_POST['lugar'] ?? '');
  $descripcion = trim($_POST['descripcion'] ?? '');

  if ($titulo === '' || $fecha === '') {
    header("Location: admin_eventos.php?err=" . urlencode("Título y fecha son obligatorios."));
    exit();
  }

  // Espera formato "YYYY-MM-DDTHH:MM" del input datetime-local
  $dt = DateTime::createFromFormat('Y-m-d\TH:i', $fecha);
  if (!$dt) {
    header("Location: admin_eventos.php?err=" . urlencode("Fecha inválida."));
    exit();
  }
  $fechaSQL = $dt->format('Y-m-d H:i:s');

  $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_inicio, lugar) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss", $titulo, $descripcion, $fechaSQL, $lugar);
  if ($stmt->execute()) {
    header("Location: admin_eventos.php?ok=1");
    exit();
  } else {
    header("Location: admin_eventos.php?err=" . urlencode("No se pudo guardar el evento."));
    exit();
  }
}

// Listado
$lista = $conn->query("SELECT * FROM eventos ORDER BY fecha_inicio ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Eventos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Gestionar Eventos</h2>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-secondary btn-sm" href="admin_web.php">Volver</a>
      <a class="btn btn-outline-danger btn-sm" href="logout.php">Salir</a>
    </div>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Evento guardado ✅</div>
  <?php endif; ?>
  <?php if (isset($_GET['err'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['err']); ?></div>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">Crear evento</div>
        <div class="card-body">
          <form method="POST">
            <div class="mb-2">
              <label class="form-label">Título</label>
              <input class="form-control" name="titulo" required>
            </div>

            <div class="mb-2">
              <label class="form-label">Fecha y hora</label>
              <input class="form-control" type="datetime-local" name="fecha_inicio" required>
            </div>

            <div class="mb-2">
              <label class="form-label">Lugar (opcional)</label>
              <input class="form-control" name="lugar">
            </div>

            <div class="mb-3">
              <label class="form-label">Descripción (opcional)</label>
              <textarea class="form-control" name="descripcion" rows="4"></textarea>
            </div>

            <button class="btn btn-primary w-100">Guardar evento</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">Eventos</div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Título</th>
                  <th>Lugar</th>
                  <th style="width:120px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php while($e = $lista->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($e['fecha_inicio']))); ?></td>
                  <td><?php echo htmlspecialchars($e['titulo']); ?></td>
                  <td><?php echo htmlspecialchars($e['lugar'] ?? ''); ?></td>
                  <td>
                    <a class="btn btn-sm btn-outline-danger"
                       href="eliminar_evento.php?id=<?php echo (int)$e['id']; ?>"
                       onclick="return confirm('¿Borrar este evento?');">
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
