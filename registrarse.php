<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "hospital");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $Nombre = $_POST["Nombre"];
    $Apellido_Paterno = $_POST["Apellido_Paterno"];
    $Apellido_Materno = $_POST["Apellido_Materno"];
    $Edad = $_POST["Edad"];
    $Sexo = $_POST["Sexo"];
    $Correo = $_POST["Correo"];
    $usuario = $_POST['usuario'];
    $contraseña = md5($_POST["contraseña"]);
    $ConfirmaContraseña = md5($_POST["ConfirmaContraseña"]);

    if ($contraseña !== $ConfirmaContraseña) {
        die("Error: Las contraseñas no coinciden.");
    }

    // Corrige la sentencia SQL para que coincida con los campos de la tabla pacientes
    $stmt = $conexion->prepare("INSERT INTO pacientes (Nombre, Apellido_Paterno, Apellido_Materno, Edad, Sexo, Correo, usuario, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiisss", $Nombre, $Apellido_Paterno, $Apellido_Materno, $Edad, $Sexo, $Correo, $usuario, $contraseña);

    if ($stmt->execute()) {
        // Redirigir al login específico para pacientes
        header("Location: login_paciente.php");
        exit;
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Proyecto de base de datos"/>
    <meta name="author" content="Veruete Hernandez Bryan David"/>
    <meta name="author" content="Tadeo Martínez Xiadani Alexahyatt "/>
    <meta name="author" content="Reyes León José Ramón "/>
    <meta name="keywords" content="HTML, CSS, JS, SQL, PHP"/>
    <title>Registrarse</title>
</head>
<style>
    .registro {
        text-align: center;
        size: 20px;
        border-radius: 2em;
        border: 1 px solid black;
    }
</style>
<body>
    <div class="registro">
        <form method="post" action="registrarse.php">
            <label for="Nombre">Nombre:</label>
            <input type="text" name="Nombre" required placeholder="Alan">
            <br><br>
            <label for="Apellido_Paterno">Apellido_Paterno:</label>
            <input type="text" name="Apellido_Paterno" required placeholder="rosas">
            <br><br>
            <label for="Apellido_Materno">Apellido_Materno:</label>
            <input type="text" name="Apellido_Materno" required placeholder="solano">
            <br><br>
            <label for="Correo">Correo:</label>
            <input type="email" name="Correo" required placeholder="123@...">
            <br><br>
            
            <label for="Edad">Edad:</label>
            <input type="number" name="Edad" required placeholder="20">
            <br><br>
            <label for="Sexo">Sexo:</label>
            <select name="Sexo" id="sexo">
                <option value="H">Hombre</option>
                <option value="M">Mujer</option>
            </select>
            <br><br>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario">
            <br><br>
            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" required>
            <br><br>
            <label for="ConfirmaContraseña">Confirmar Contraseña:</label>
            <input type="password" name="ConfirmaContraseña" required>
            <br><br>
            <input type="submit" value="Registrarse">
        </form>
    </div>
</body>
</html>
