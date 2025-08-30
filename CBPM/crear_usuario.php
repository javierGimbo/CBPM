<?php
include('conexion.php');

$nombre = "javi";
$contraseña = "cbpmweb"; // tu contraseña en texto plano
$rol = "administrador";

// Generar hash seguro
$hash = password_hash($contraseña, PASSWORD_DEFAULT);

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (nombre, contraseña, rol) VALUES ('$nombre', '$hash', '$rol')";

if($conn->query($sql)) {
    echo "Usuario creado correctamente";
} else {
    echo "Error: " . $conn->error;
}
?>
