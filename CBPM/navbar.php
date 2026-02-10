<?php
// Requiere que ya exista $conn (conexion.php incluido antes)
?>
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar mb-3">
  <div class="container-fluid justify-content-center">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="menuNav">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" href="index.php">Inicio</a>
        </li>

        <!-- Equipos dinámicos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Equipos</a>
          <ul class="dropdown-menu">
            <?php
              $equiposNav = $conn->query("SELECT slug, nombre FROM equipos ORDER BY nombre");
              while ($e = $equiposNav->fetch_assoc()) {
                echo '<li><a class="dropdown-item" href="equipo.php?equipo=' . urlencode($e['slug']) . '">'
                  . htmlspecialchars($e['nombre']) . '</a></li>';
              }
            ?>
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
