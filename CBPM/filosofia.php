<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBPM - Filosofia</title>
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
        <nav class="navbar navbar-expand-lg navbar-dark custom-navbar mb-3">
      <div class="container-fluid justify-content-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="menuNav">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Equipos</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="alevin.php">Alevin</a></li>
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
                <li><a class="dropdown-item" href="palmares.php">Palmares</a></li>
                <li><a class="dropdown-item" href="junta.php">Junta Directiva</a></li>
                <li><a class="dropdown-item" href="entrenadores.php">Entrenadores</a></li>
                <li><a class="dropdown-item" href="filosofia.php">Filosofia</a></li>
                <li><a class="dropdown-item" href="codigo.php">Código Disciplinario</a></li>
              </ul>
            </li>

            <li class="nav-item"><a class="nav-link" href="#">Patrocinadores</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Fotso</a></li>
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
  <h1>Filosofía</h1>

  <div class="card shadow-sm p-4">
    <h3 class="mb-3">¿Qué buscamos desde el CB PINO MONTANO en el desarrollo de nuestra actividad?</h3>
    <p>
      En nuestro club llevamos más de 8 años comprometidos con nuestro barrio, nuestros jugadores, nuestros entrenadores… 
      Este compromiso se basa en la premisa de que todos y cada uno de ellos tienen que comprender el concepto de 
      <strong>DEPORTIVIDAD Y COMPROMISO</strong>.
    </p>

    <p>
      Estas palabras, las cuales han sido usadas tantas veces en vano que ya parecen una más, son esenciales para nosotros. 
      Debemos proteger y cuidar estos conceptos porque son indispensables para el buen desarrollo de la actividad deportiva en jóvenes.
      Cualquier jugador que este en nuestras filas debe comprender que el equipo está antes que cualquier otra cosa, 
      el respeto por los entrenadores y amigos, el respeto por los rivales… ¡Todo ello es imprescindible!
    </p>

    <p>
      La competitividad en estas edades debe basarse más que en una lucha contra el rival, en una lucha de nosotros mismos como jugadores 
      para mejorar cada día y sentirnos mejor con nosotros mismos. Tenemos que luchar por demostrarle al mundo que somos valiosos por lo 
      bien que lo hacemos, no hablamos de meter muchos puntos, hablamos de dar ejemplo en cada paso que damos dentro de la pista. 
      Cada entrenamiento es una nueva oportunidad, una herramienta la del baloncesto creada para unir a compañeros y para llegar a objetivos comunes.
    </p>

    <p>
      Los entrenamientos <strong>NO quitan tiempo para estudiar</strong>. No hace falta que venga ningún experto ni que aludamos a estudios 
      científicos para saber que las habilidades sociales e individuales que aprendemos dentro del contexto del equipo y los entrenamientos, 
      son esenciales para el buen desarrollo de los jóvenes. Es una motivación, es una manera de socializar, el sacrificio que les aporta… 
      En un mundo donde prima la fugacidad y la rapidez con la que consumimos todo, esa hora y media de entrenamiento les sirve para mejorar su concentración. 
      Esa focalización de objetivos y de intentar superarlos, es clave para el éxito de ellos, cuando vamos a entrenar estamos entrenando también conductas tremendamente beneficiosas.
    </p>

    <p>
      En cuanto a deportividad, nunca hemos tenido problemas con la mayoría de nuestros jugadores y categorías. 
      Aun así, siempre hay que recordar que cuando estamos en la pista de baloncesto, estamos en un lugar de respeto y de armonía. 
      No se pueden permitir ni tolerar comportamientos denigrantes hacia entrenadores, compañeros ni mucho menos rivales. 
      Somos altamente estrictos con estas cuestiones. Desde los inicios de los entrenamientos en septiembre, 
      el clima de trabajo debe respirar seriedad, compromiso y respeto, es parte fundamental de este juego llamado baloncesto.
    </p>

    <blockquote class="blockquote text-center mt-4">
      <p class="mb-0">“Juega por el nombre que llevas delante del pecho, no por el que llevas en tu espalda”</p><br>
      <footer class="blockquote-footer">José Manuel Calderón</footer>
    </blockquote>

    <p class="mt-3"><strong>¡Compromiso y respeto por todas y todos!</strong></p>
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

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="main.js"></script>
</body>
</html>
