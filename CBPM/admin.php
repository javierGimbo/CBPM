<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] != "administrador") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION["usuario"]; ?></h1>
    <a href="noticias.php">📰 Gestionar Noticias</a><br>
    <a href="logout.php">🚪 Cerrar Sesión</a>
</body>
</html>
