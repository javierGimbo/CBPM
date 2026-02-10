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

  <!-- VISITAS (usa $visitas del index) -->
  <div class="card mb-3">
    <div class="card-header">👀 Visitas a la web</div>
    <div class="card-body text-center">
      <h5><?php echo (int)$visitas; ?> visitas</h5>
    </div>
  </div>

  <!-- CUMPLEAÑOS (por ahora fijo) -->
  <div class="card mb-3">
    <div class="card-header">🎂 Cumpleaños</div>
    <div class="card-body">
      <p>Jugador 1 - 22 junio</p>
      <p>Jugador 2 - 30 junio</p>
    </div>
  </div>

  <!-- PATROCINADOR -->
  <div class="card mb-3">
    <div class="card-header">Patrocinador Oficial</div>
    <div class="card-body">
      <img src="media/delvalle.png" alt="Patrocinador" style="max-width:100%;">
    </div>
  </div>

  <!-- INSTAGRAM -->
  <div class="card mb-3">
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

  <!-- TIEMPO -->
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
