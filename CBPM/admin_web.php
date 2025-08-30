<?php
session_start();

// Solo dejar pasar si hay sesión iniciada
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Página de prueba</title>
</head>
<body>
<h2>Agregar Nueva Noticia</h2>
<form action="guardar_noticia.php" method="POST" enctype="multipart/form-data">
    <div>
        <label>Título:</label><br>
        <input type="text" name="titulo" required style="width:100%">
    </div>
    <div>
        <label>Encabezado:</label><br>
        <input type="text" name="encabezado" required style="width:100%">
    </div>
    <div>
        <label>Cuerpo de la noticia:</label><br>
        <textarea id="cuerpo" name="cuerpo" rows="10"></textarea>
    </div>
    <button type="submit">Guardar Noticia</button>
</form>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/xxlcyxg9yyxyjalizosj10gq6uahn8ryks8zpx4ut0jkh2ts/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#cuerpo',   // aquí debe coincidir con el id del <textarea>
    height: 300,
    menubar: false,
    plugins: 'lists link image preview',
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | preview'
  });
</script>


<a href="logout.php">Cerrar sesión</a>
</body>
</html>
