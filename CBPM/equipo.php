<?php
include 'conexion.php';

/* CONTADOR DE VISITAS para que sidebar.php sea igual */
$archivo = "visitas.txt";
if (!file_exists($archivo)) file_put_contents($archivo, "0");

$esExterno = true;
if (isset($_SERVER['HTTP_REFERER'])) {
  if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false) {
    $esExterno = false;
  }
}

$visitas = (int)file_get_contents($archivo);
if ($esExterno) {
  $visitas++;
  file_put_contents($archivo, $visitas);
}

$slug = trim($_GET['equipo'] ?? '');
if ($slug === '') {
  header("Location: index.php");
  exit();
}

// Buscar el equipo
$stmt = $conn->prepare("SELECT id, nombre, slug FROM equipos WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$equipoRes = $stmt->get_result();

if ($equipoRes->num_rows !== 1) {
  header("Location: index.php");
  exit();
}

$equipo = $equipoRes->fetch_assoc();
$equipo_id = (int)$equipo['id'];

// Sacar plantilla (con rol)
$stmt = $conn->prepare("
  SELECT j.nombre, j.apellidos, j.sexo, j.foto, j.fecha_nacimiento,
         p.dorsal, p.rol
  FROM plantilla p
  JOIN jugadores j ON j.id = p.jugador_id
  WHERE p.equipo_id = ?
  ORDER BY p.rol DESC, j.apellidos, j.nombre
");
$stmt->bind_param("i", $equipo_id);
$stmt->execute();
$res = $stmt->get_result();

// Separar entrenadores / jugadores
$entrenadores = [];
$jugadoresLista = [];

while ($r = $res->fetch_assoc()) {
  if (($r['rol'] ?? '') === 'entrenador') $entrenadores[] = $r;
  else $jugadoresLista[] = $r;
}

function fotoPersona($row) {
  return !empty($row['foto']) ? $row['foto'] : 'media/jugadores/default.png';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBPM - <?php echo htmlspecialchars($equipo['nombre']); ?></title>

  <link rel="icon" type="image/png" href="media/Logo-png-1.png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container-white">

    <!-- HEADER -->
    <header class="position-relative py-2">
      <img src="media/sINCE-2010-1-1024x231.png" class="w-100" alt="Imagen del Club">
      <img src="media/Logo-png-1.png" class="position-absolute logo"
           style="bottom:20px; left:20px; height:100px;"
           alt="Logo del Club">
    </header>

    <!-- NAVBAR -->
    <?php include 'navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container my-4">
      <div class="row g-4 align-items-start">

        <!-- CONTENIDO EQUIPO -->
        <div class="col-lg-8">
          <h2 class="mb-3"><?php echo htmlspecialchars($equipo['nombre']); ?></h2>

          <!-- Foto grande del equipo (opcional) -->
          <img src="imagenes/<?php echo htmlspecialchars($equipo['slug']); ?>_grupo.jpg"
               alt="Equipo <?php echo htmlspecialchars($equipo['nombre']); ?>"
               class="equipo-img mb-4"
               onerror="this.style.display='none'">

          <?php if (count($entrenadores) === 0 && count($jugadoresLista) === 0): ?>
            <p class="text-muted">Aún no hay personas añadidas a esta plantilla.</p>
          <?php endif; ?>

          <!-- ENTRENADORES -->
          <?php if (count($entrenadores) > 0): ?>
            <h4 class="mt-2 mb-3">Entrenadores</h4>
            <div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
              <?php foreach ($entrenadores as $j): ?>
                <?php
                  $nombreCompleto = trim(($j['nombre'] ?? '') . ' ' . ($j['apellidos'] ?? ''));
                  $foto = fotoPersona($j);

                  $fechaBonita = '';
                  if (!empty($j['fecha_nacimiento'])) {
                    $fechaBonita = date('d/m/Y', strtotime($j['fecha_nacimiento']));
                  }
                ?>
                <div class="col jugador-card">
                  <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($nombreCompleto); ?>">
                  <div class="jugador-nombre"><?php echo htmlspecialchars($nombreCompleto); ?></div>
                  <?php if ($fechaBonita !== ''): ?>
                    <div style="font-size:0.85rem; color:#555;"><?php echo htmlspecialchars($fechaBonita); ?></div>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <!-- JUGADORES -->
          <?php if (count($jugadoresLista) > 0): ?>
            <h4 class="mt-2 mb-3">Jugadores</h4>
            <div class="row row-cols-2 row-cols-md-4 g-3">
              <?php foreach ($jugadoresLista as $j): ?>
                <?php
                  $nombreCompleto = trim(($j['nombre'] ?? '') . ' ' . ($j['apellidos'] ?? ''));
                  $foto = fotoPersona($j);

                  $dorsalTxt = '';
                  if ($j['dorsal'] !== null && $j['dorsal'] !== '') {
                    $dorsalTxt = '#' . (int)$j['dorsal'];
                  }

                  $fechaBonita = '';
                  if (!empty($j['fecha_nacimiento'])) {
                    $fechaBonita = date('d/m/Y', strtotime($j['fecha_nacimiento']));
                  }
                ?>
                <div class="col jugador-card">
                  <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($nombreCompleto); ?>">
                  <div class="jugador-nombre"><?php echo htmlspecialchars($nombreCompleto); ?></div>

                  <?php if ($dorsalTxt !== ''): ?>
                    <div style="font-weight:700; margin-top:4px;"><?php echo htmlspecialchars($dorsalTxt); ?></div>
                  <?php endif; ?>

                  <?php if ($fechaBonita !== ''): ?>
                    <div style="font-size:0.85rem; color:#555;"><?php echo htmlspecialchars($fechaBonita); ?></div>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

        </div>

        <!-- SIDEBAR -->
        <div class="col-lg-4">
          <?php include 'sidebar.php'; ?>
        </div>

      </div>
    </div>

    <!-- FOOTER -->
    <footer>
      <p>&copy; 2025 Club de Baloncesto. Todos los derechos reservados.</p>
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
