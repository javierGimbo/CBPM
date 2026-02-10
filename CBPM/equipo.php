<?php
include 'conexion.php';

$slug = $_GET['equipo'] ?? '';
$slug = trim($slug);

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
  // si no existe, volvemos al inicio
  header("Location: index.php");
  exit();
}

$equipo = $equipoRes->fetch_assoc();
$equipo_id = (int)$equipo['id'];

// Sacar jugadores de la plantilla
$stmt = $conn->prepare("
  SELECT j.nombre, j.apellidos, j.sexo, j.foto, j.fecha_nacimiento, p.dorsal
  FROM plantilla p
  JOIN jugadores j ON j.id = p.jugador_id
  WHERE p.equipo_id = ?
  ORDER BY j.apellidos, j.nombre
");
$stmt->bind_param("i", $equipo_id);
$stmt->execute();
$jugadores = $stmt->get_result();
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

    <!-- NAVBAR (Equipos dinámicos también aquí) -->
   <?php
include 'conexion.php';
include 'navbar.php';
?>


    <!-- CONTENIDO PRINCIPAL -->
    <div class="container my-4">
      <div class="row">

        <div class="col-lg-8">
          <h2 class="mb-3"><?php echo htmlspecialchars($equipo['nombre']); ?></h2>

          <!-- Foto grande del equipo (opcional, cambia si quieres) -->
          <img src="imagenes/<?php echo htmlspecialchars($equipo['slug']); ?>_grupo.jpg"
               alt="Equipo <?php echo htmlspecialchars($equipo['nombre']); ?>"
               class="equipo-img mb-4"
               onerror="this.style.display='none'">

          <!-- Mosaico de jugadores -->
          <div class="row row-cols-2 row-cols-md-4 g-3">
            <?php if ($jugadores->num_rows === 0): ?>
              <p class="text-muted">Aún no hay jugadores añadidos a esta plantilla.</p>
            <?php else: ?>
              <?php while ($j = $jugadores->fetch_assoc()): ?>
                <?php
                  $nombreCompleto = trim(($j['nombre'] ?? '') . ' ' . ($j['apellidos'] ?? ''));
                  $foto = !empty($j['foto']) ? $j['foto'] : 'media/jugadores/default.png';

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

                  <?php if ($dorsalTxt !== '' || $fechaBonita !== ''): ?>
                    <div style="font-weight:700; margin-top:4px;"><?php echo htmlspecialchars($dorsalTxt); ?></div>
                    <div style="font-size:0.85rem; color:#555;"><?php echo htmlspecialchars($fechaBonita); ?></div>
                  <?php endif; ?>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- SIDEBAR (puedes copiar el mismo que ya usas en otras páginas) -->
        <div class="col-lg-4">
          <div class="sidebar">

            <div class="card mb-3">
              <div class="card-header">⏳ Próximo evento</div>
              <div class="card-body text-center">
                <h6>comienzo de la temporada</h6>
                <p><strong>15 Septiembre 2025, 18:00h</strong></p>
                <div id="countdown" style="font-size:1.2rem; font-weight:bold;"></div>
              </div>
            </div>

            <div class="card">
              <div class="card-header">🎂 Cumpleaños</div>
              <div class="card-body">
                <p>Jugador 1 - 22 junio</p>
                <p>Jugador 2 - 30 junio</p>
              </div>
            </div>

            <div class="card">
              <div class="card-header">Patrocinador Oficial</div>
              <div class="card-body">
                <img src="media/delvalle.png" alt="Patrocinador">
              </div>
            </div>

            <div class="card">
              <div class="card-header">🌐 ÚLTIMO POST EN INSTAGRAM</div>
              <div class="card-body">
                <blockquote class="instagram-media"
                  data-instgrm-permalink="https://www.instagram.com/p/DMfyNSltGLt/?img_index=1"
                  data-instgrm-version="14"
                  style="background:#FFF; border:0; margin:1px; max-width:540px; min-width:326px; width:100%">
                </blockquote>
                <script async src="//www.instagram.com/embed.js"></script>
              </div>
            </div>

            <a class="weatherwidget-io"
              href="https://forecast7.com/es/37d39n5d98/seville/"
              data-label_1="SEVILLA" data-label_2="WEATHER" data-theme="original">
              SEVILLA WEATHER
            </a>
            <script>
              !function(d,s,id){
                var js,fjs=d.getElementsByTagName(s)[0];
                if(!d.getElementById(id)){
                  js=d.createElement(s);js.id=id;
                  js.src='https://weatherwidget.io/js/widget.min.js';
                  fjs.parentNode.insertBefore(js,fjs);
                }
              }(document,'script','weatherwidget-io-js');
            </script>

          </div>
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
