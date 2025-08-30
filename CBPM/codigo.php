<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CBPM - Código Disciplinario</title>
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
                    <h1>Código disciplinario</h1>

                    <div class="card shadow-sm p-4">
                        <p>
                            Cada uno de los miembros que conforman el <strong>Club Baloncesto Pino Montano 2010</strong>
                            han de acatar una serie de normas para el correcto funcionamiento de la entidad.
                            Estas pautas deben cumplirse siempre y mientras que dicha persona esté bajo la disciplina
                            del C.D Pino Montano 2010, entendiendo en todo momento que pertenecen a una entidad que
                            aboga por el <strong>respeto, la solidaridad y el deporte</strong> como pilares centrales.
                        </p>

                        <h3 class="mt-4">Entrenadores</h3>
                        <p>
                            El objetivo principal de un entrenador/a es la formación de sus jugadores y jugadoras.
                            Uno de los principales objetivos dentro de una temporada deportiva es llegar a crear
                            un entorno idóneo para los chicos/as. Esto consiste en corregir y modificar comportamientos
                            injustos o poco adecuados de unos compañeros hacia otros, trabajando día a día para hacer
                            comprender a los jugadores que cada uno de los integrantes del equipo son una pieza clave
                            dentro del mismo.
                        </p>
                        <p>
                            El entrenador consensuará con la directiva a principios de temporada el tipo de sesiones y estilo
                            de juego que quiere lograr en su equipo. Esta decisión será tomada tras consenso de las dos partes
                            (junta directiva y entrenador/a), buscando siempre el aprendizaje y desarrollo deportivo y social
                            de nuestros chicos/as.
                        </p>
                        <p>
                            El entrenador debe volcar sus esfuerzos en motivar y enseñar a sus jugadores.
                            Las victorias cuentan, pero <strong>saber jugar bien a baloncesto y tener un equipo solidario</strong>
                            que actúa como verdadero grupo en las adversidades, aún más.
                        </p>
                        <p>
                            Para mayor tranquilidad del entrenador/a, este no deberá involucrarse en asuntos como:
                            cambios de partido, conversaciones con otros equipos o contactar con el IMD. Para eso,
                            existe una junta directiva que realizará dichas labores siempre con el previo diálogo
                            con los entrenadores.
                        </p>
                        <p>
                            La relación con los padres y madres debe ser continua. Deben estar informados con frecuencia
                            de las novedades respecto a la formación de su hijo/a. Además, el entrenador creará un grupo
                            de Whatsapp para una mejor comunicación de los horarios de entrenamientos, de partidos y de
                            las eventualidades que pudieran surgir.
                        </p>

                        <h3 class="mt-4">Jugadores</h3>
                        <p>
                            El respeto por los demás compañeros y por el entrenador debe ser la tónica habitual de los entrenamientos.
                            <strong>NO SE TOLERARÁ</strong> una falta de respeto hacia ninguno de los componentes del grupo.
                            Esto puede llevar desde el retiro temporal hasta la expulsión definitiva de dicho jugador.
                        </p>
                        <p>
                            Por otro lado, el respeto hacia los demás contrincantes, árbitros y entrenadores deberá ser <strong>MÁXIMO</strong>.
                            Hay que entender que se trata de jugadores y jugadoras amigos/as del baloncesto,
                            que intentan jugar lo mejor posible y disfrutar en la cancha.
                        </p>

                        <h4 class="mt-3">La puntualidad</h4>
                        <p>
                            Los entrenamientos tienen una fecha fija para toda la temporada, a excepción de momentos puntuales,
                            cuyas modificaciones serán transmitidas a los padres/madres por parte del entrenador.
                            Dicho esto, los jugadores deben hacer siempre acto de presencia en la cancha al menos
                            <strong>5 minutos antes</strong> del inicio del entrenamiento. La asistencia será controlada
                            por el entrenador, que a final de semana y basándose en dichas anotaciones, convocará (en caso de ser necesario)
                            a los jugadores que mayor asistencia hayan tenido a los entrenamientos.
                        </p>
                        <p class="fst-italic">
                            * A excepción de algunos casos en los que por lesión, enfermedad u otros motivos se falte al entrenamiento.
                        </p>
                        <p>
                            La asistencia <strong>INJUSTIFICADA</strong> de una sesión será motivo para no convocar al jugador
                            (entendiendo INJUSTIFICADAS como la no asistencia sin motivo de por medio).
                            En la medida de lo posible, el jugador debe avisar de su falta de asistencia al menos
                            dos horas antes del inicio del entrenamiento, <strong>SIEMPRE</strong>.
                        </p>

                        <p class="text-center mt-4 fw-bold">#CBPM</p>
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