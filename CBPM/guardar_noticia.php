<?php
session_start();
include 'conexion.php';

// Verifica que haya sesión de administrador
if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'administrador'){
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titulo = $_POST['titulo'];
    $encabezado = $_POST['encabezado'];
    $cuerpo = $_POST['cuerpo'];

    $sql = "INSERT INTO noticias (titulo, encabezado, cuerpo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $titulo, $encabezado, $cuerpo);

    if($stmt->execute()){
        echo "Noticia guardada correctamente. <a href='admin_prueba.php'>Volver</a>";
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
