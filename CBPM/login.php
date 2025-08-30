<?php
session_start();
include 'conexion.php';

if(isset($_POST['usuario']) && isset($_POST['contraseña'])){
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE nombre=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){
        $fila = $resultado->fetch_assoc();
        if(password_verify($contraseña, $fila['contraseña'])){
            $_SESSION['usuario'] = $fila['nombre'];
            $_SESSION['rol'] = $fila['rol'];

            // Redirigir a la página de prueba
            header("Location: admin_web.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login CBPM</title>
</head>
<body>
<h2>Login CBPM</h2>
<form method="post" action="">
    Usuario: <input type="text" name="usuario" required><br>
    Contraseña: <input type="password" name="contraseña" required><br>
    <button type="submit">Entrar</button>
</form>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
