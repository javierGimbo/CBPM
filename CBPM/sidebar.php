<div class="sidebar">

  <?php
  // =======================
  // PRÓXIMO EVENTO (BD)
  // =======================
  $prox = $conn->query("
    SELECT * FROM eventos
    WHERE fecha_inicio >= NOW()
    ORDER BY fecha_inicio ASC
    LIMIT 1
  ")->fetch_assoc();
  ?>

  <div class="sidebar-section">
    <div class="sidebar-title">⏳ Próximo evento</div>
    <div class="sidebar-body text-center">
      <?php if ($prox): ?>
        <h6><?php echo htmlspecialchars($prox['titulo']); ?></h6>
        <p><strong><?php echo date('d/m/Y, H:i', strtotime($prox['fecha_inicio'])); ?>h</strong></p>

        <?php if (!empty($prox['lugar'])): ?>
          <div class="text-muted"><?php echo htmlspecialchars($prox['lugar']); ?></div>
        <?php endif; ?>

      <?php else: ?>
        <p class="text-muted mb-0">No hay eventos próximos.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- VISITAS -->
  <div class="sidebar-section">
    <div class="sidebar-title">👀 Visitas a la web</div>
    <div class="sidebar-body text-center">
      <h5><?php echo (int)$visitas; ?> visitas</h5>
    </div>
  </div>

  <?php
  // =======================
  // CUMPLEAÑOS (BD)
  // Próximos 2 cumpleaños
  // =======================

$cumples = $conn->query("
  SELECT
    id, nombre, apellidos, fecha_nacimiento, foto,
    CASE
      WHEN DATE_FORMAT(fecha_nacimiento, '%m-%d') >= DATE_FORMAT(CURDATE(), '%m-%d')
        THEN STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', DATE_FORMAT(fecha_nacimiento, '%m-%d')), '%Y-%m-%d')
      ELSE
        STR_TO_DATE(CONCAT(YEAR(CURDATE()) + 1, '-', DATE_FORMAT(fecha_nacimiento, '%m-%d')), '%Y-%m-%d')
    END AS proximo_cumple
  FROM jugadores
  WHERE fecha_nacimiento IS NOT NULL
  ORDER BY proximo_cumple ASC
  LIMIT 3
");
?>

<div class="sidebar-section">
  <div class="sidebar-title">🎂 Cumpleaños</div>
  <div class="sidebar-body">

    <?php if ($cumples->num_rows === 0): ?>
      <p class="text-muted mb-0">No hay jugadores con fecha.</p>
    <?php else: ?>

      <?php while($j = $cumples->fetch_assoc()): 
        $foto = !empty($j['foto']) ? $j['foto'] : 'media/jugadores/default.png';
      ?>

        <div class="cumple-item">
          <img src="<?php echo htmlspecialchars($foto); ?>" alt="Jugador">

          <div>
            <div class="cumple-nombre">
              <?php echo htmlspecialchars($j['nombre'] . " " . $j['apellidos']); ?>
            </div>
            <div class="cumple-fecha">
              <?php echo date('d/m', strtotime($j['fecha_nacimiento'])); ?>
            </div>
          </div>
        </div>

      <?php endwhile; ?>

    <?php endif; ?>

  </div>
</div>

  <!-- PATROCINADOR -->
  <div class="sidebar-section">
    <div class="sidebar-title">Patrocinador Oficial</div>
    <div class="sidebar-body">
      <img src="media/delvalle.png" alt="Patrocinador">
    </div>
  </div>

  <!-- INSTAGRAM -->
  <div class="sidebar-section">
    <div class="sidebar-title">🌐 ÚLTIMO POST EN INSTAGRAM</div>
    <div class="sidebar-body">
      <blockquote class="instagram-media"
        data-instgrm-permalink="https://www.instagram.com/p/DMfyNSltGLt/?img_index=1"
        data-instgrm-version="14"
        style="background:#FFF; border:0; margin:1px; width:100%;">
      </blockquote>
      <script async src="//www.instagram.com/embed.js"></script>

      <a href="#" class="d-block mt-2">Facebook</a>
      <a href="#" class="d-block">Twitter</a>
    </div>
  </div>

  <!-- TIEMPO -->
  <div class="sidebar-section">
    <div class="sidebar-title">☀️ Tiempo</div>
    <div class="sidebar-body">
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
