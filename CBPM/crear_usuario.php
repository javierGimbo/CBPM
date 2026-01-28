<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Hash seguro
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert seguro con prepared statement
    $sql = "INSERT INTO usuarios (nombre, password, rol) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $hash, $rol);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error al crear el usuario</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
</head>
<body>
    <h2>Registrar Nuevo Usuario</h2>

    <form method="POST">
        <label>Nombre de Usuario:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Rol:</label><br>
        <select name="rol">
            <option value="administrador">Administrador</option>
            <option value="usuario">Usuario</option>
        </select><br><br>

        <button type="submit">Crear Usuario</button>
    </form>

    <br>
    <a href="login.php">Volver al login</a>
</body>
</html>
