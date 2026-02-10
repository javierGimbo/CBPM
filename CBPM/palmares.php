<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBPM - Palmarés</title>
  <link rel="icon" type="image/png" href="media/Logo-png-1.png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container-white">

    <!-- HEADER -->
    <header class="position-relative py-2">
      <img src="media/sINCE-2010-1-1024x231.png" class="w-100" alt="Imagen del Club">
      <img src="media/Logo-png-1.png" class="position-absolute logo"
        style="bottom: 20px; left: 20px; height: 100px;"
        alt="Logo del Club">
    </header>

    <!-- NAVBAR -->
    <?php
include 'conexion.php';
include 'navbar.php';
?>


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
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselClub" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container my-4">
      <div class="row">
        <!-- Columna principal (Galería Alevín) -->
        <div class="col-lg-8">
          <h1>Palmarés</h1>

          <div class="accordion" id="historicoAccordion">

            <!-- 2010-2011 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading2010">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2010" aria-expanded="false" aria-controls="collapse2010">
                  Temporada 2010-2011
                </button>
              </h2>
              <div id="collapse2010" class="accordion-collapse collapse" aria-labelledby="heading2010" data-bs-parent="#historicoAccordion">
                <div class="accordion-body">
                  <ul>
                    <li>CADETES: 6º Clasificado Grupo E-01 Juegos Deportivos Municipales (1 Victoria, 11 Derrotas)</li>
                    <li>CADETES: 2º Clasificado Grupo PN-01 Juegos de Primavera (3 Victorias, 2 Derrotas)</li>
                    <li>SENIOR: 6º Clasificado Grupo PN-02 Juegos de Primavera (0 Victorias, 6 Derrotas)</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- 2011-2012 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading2011">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2011" aria-expanded="false" aria-controls="collapse2011">
                  Temporada 2011-2012
                </button>
              </h2>
              <div id="collapse2011" class="accordion-collapse collapse" aria-labelledby="heading2011" data-bs-parent="#historicoAccordion">
                <div class="accordion-body">
                  <ul>
                    <li>CADETES: 5º Clasificado Grupo N-01 Juegos Deportivos Municipales (2 Victorias, 7 Derrotas)</li>
                    <li>SENIOR: 4º Clasificado Grupo SP-01 Juegos de Primavera (1 Victoria, 3 Derrotas)</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- 2012-2013 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading2012">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2012" aria-expanded="false" aria-controls="collapse2012">
                  Temporada 2012-2013
                </button>
              </h2>
              <div id="collapse2012" class="accordion-collapse collapse" aria-labelledby="heading2012" data-bs-parent="#historicoAccordion">
                <div class="accordion-body">
                  <ul>
                    <li>...</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- 2013-2014 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading2013">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2013" aria-expanded="false" aria-controls="collapse2013">
                  Temporada 2013-2014
                </button>
              </h2>
              <div id="collapse2013" class="accordion-collapse collapse" aria-labelledby="heading2013" data-bs-parent="#historicoAccordion">
                <div class="accordion-body">
                  <ul>
                    <li>...</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Repite la estructura para cada temporada -->
            <!-- 2014-2015 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading2014">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2014" aria-expanded="false" aria-controls="collapse2014">
                  Temporada 2014-2015
                </button>
              </h2>
              <div id="collapse2014" class="accordion-collapse collapse" aria-labelledby="heading2014" data-bs-parent="#historicoAccordion">
                <div class="accordion-body">
                  <ul>
                    <li>...</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- ... sigue igual hasta 2025 -->

            <!-- 2024-2025 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading2024">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2024" aria-expanded="false" aria-controls="collapse2024">
                  Temporada 2024-2025
                </button>
              </h2>
              <div id="collapse2024" class="accordion-collapse collapse" aria-labelledby="heading2024" data-bs-parent="#historicoAccordion">
                <div class="accordion-body">
                  <ul>
                    <li>ALEVÍN MIXTO: 3º Clasificado en Juegos Deportivos Municipales - (Accede a Fase Final, donde no consigue pasar de primera ronda) - 2º Clasificado en Juegos de Primavera 2025.</li>
                    <li>INFANTIL MIXTO AZUL: 2º Clasificado en Juegos Deportivos Municipales - (Accede a Fase Final, donde no consigue pasar de primera ronda) - 1º Clasificado en Juegos de Primavera 2025.</li>
                    <li>INFANTIL MIXTO BLANCO: 7º Clasificado en Juegos Deportivos Municipales. 4º Clasificado en Juegos de Primavera 2025.</li>
                    <li>CADETE MIXTO: 8º Clasificado en Juegos Deportivos Municipales. 4º Clasificado en Juegos de Primavera 2025.</li>
                    <li>JUVENIL MIXTO AZUL: 3º Clasificado en Juegos Deportivos Municipales. 3º Clasificado en Juegos de Primavera 2025.</li>
                    <li>JUVENIL MIXTO BLANCO: 4º Clasificado en Juegos Deportivos Municipales. 2º Clasificado en Juegos de Primavera 2025.</li>
                    <li>SENIOR: 6º Clasificado en Juegos Deportivos Municipales. 4º Clasificado en Juegos de Primavera 2025.</li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Columna del sidebar -->
        <div class="col-lg-4">
          <div class="sidebar">
            <!-- CONTADOR REGRESIVO -->
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
                <img src="media/delvalle.png">
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
                <a href="#" class="d-block">Facebook</a>
                <a href="#" class="d-block">Twitter</a>
              </div>
            </div>

            <a class="weatherwidget-io"
              href="https://forecast7.com/es/37d39n5d98/seville/"
              data-label_1="SEVILLA" data-label_2="WEATHER" data-theme="original">
              SEVILLA WEATHER
            </a>
            <script>
              ! function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (!d.getElementById(id)) {
                  js = d.createElement(s);
                  js.id = id;
                  js.src = 'https://weatherwidget.io/js/widget.min.js';
                  fjs.parentNode.insertBefore(js, fjs);
                }
              }(document, 'script', 'weatherwidget-io-js');
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

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="main.js"></script>
</body>

</html>