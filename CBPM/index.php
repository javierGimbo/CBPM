<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBPM</title>

  <link rel="icon" type="image/png" href="media/Logo-png-1.png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
</head>

<?php
$archivo = "visitas.txt";

if (!file_exists($archivo)) {
  file_put_contents($archivo, "0");
}

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
?>

<body>

  <div class="container-white">

    <!-- BARRA ADMIN (sin padding superior) -->
    <div class="d-flex justify-content-end w-100 bg-white px-2 py-1 admin-bar">
      <a href="login.php"
         class="btn btn-outline-dark"
         style="font-size:0.65rem; padding:1px 6px; border-radius:0; line-height:1;">
        Acceso Admin
      </a>
    </div>

    <!-- CONTENIDO CON PADDING NORMAL -->
    <div class="content-padding">

      <!-- HEADER -->
      <header class="position-relative py-2">
        <img src="media/sINCE-2010-1-1024x231.png" class="w-100" alt="Imagen del Club">
        <img src="media/Logo-png-1.png"
             class="position-absolute logo"
             style="bottom:20px; left:20px; height:100px;"
             alt="Logo del Club">
      </header>

      <!-- NAVBAR -->
      <nav class="navbar navbar-expand-lg navbar-dark custom-navbar mb-3">
        <div class="container-fluid justify-content-center">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="menuNav">
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Equipos</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="alevin.php">Alevín</a></li>
                  <li><a class="dropdown-item" href="infantil.php">Infantil</a></li>
                  <li><a class="dropdown-item" href="cadete.php">Cadete</a></li>
                  <li><a class="dropdown-item" href="juvenil.php">Juvenil</a></li>
                  <li><a class="dropdown-item" href="senior.php">Senior</a></li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Nuestro Club</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="historia.php">Historia</a></li>
                  <li><a class="dropdown-item" href="palmares.php">Palmarés</a></li>
                  <li><a class="dropdown-item" href="junta.php">Junta Directiva</a></li>
                  <li><a class="dropdown-item" href="entrenadores.php">Entrenadores</a></li>
                  <li><a class="dropdown-item" href="filosofia.php">Filosofía</a></li>
                  <li><a class="dropdown-item" href="codigo.php">Código Disciplinario</a></li>
                </ul>
              </li>

              <li class="nav-item"><a class="nav-link" href="#">Patrocinadores</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Fotos</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- CARRUSEL -->
      <div id="carouselClub" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="media/foto para header.jpg" class="d-block w-100" alt="CBPM">
            <div class="carousel-caption d-none d-md-block">
              <h5>¡Bienvenid@ a la web del CBPM!</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="media/logo-DV-baloncsto_070225-1.png" class="d-block w-100" alt="Del Valle">
          </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselClub" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselClub" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

      <!-- CONTENIDO PRINCIPAL -->
      <div class="container my-4">
        <div class="row">

          <!-- NOTICIAS -->
          <div class="col-lg-8">
            <?php
            include 'conexion.php';
            $result = $conn->query("SELECT * FROM noticias ORDER BY fecha DESC");

            while ($row = $result->fetch_assoc()) {
              echo "<div class='card mb-3'>";
              echo "<div class='card-header'><h3>{$row['titulo']}</h3></div>";
              echo "<div class='card-body'>";
              echo "<h5>{$row['encabezado']}</h5>";
              echo "<p>{$row['cuerpo']}</p>";
              echo "</div></div>";
            }
            ?>
          </div>

          <!-- SIDEBAR -->
          <div class="col-lg-4">
            <div class="card mb-3">
              <div class="card-header">👀 Visitas</div>
              <div class="card-body text-center">
                <h5><?php echo $visitas; ?> visitas</h5>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- FOOTER -->
      <footer>
        <p>&copy; 2025 Club de Baloncesto. Todos los derechos reservados.</p>
      </footer>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
