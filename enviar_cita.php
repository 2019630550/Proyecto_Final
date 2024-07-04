<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$apellidoPaterno = $_POST['Apellido_Paterno'];
$apellidoMaterno = $_POST['Apellido_Materno'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$citaDia = $_POST['cita_dia'];
$citaHora = $_POST['cita_hora'];
$curp = $_POST['CURP'];
$especialidad = $_POST['especialidad'];
$doctor = $_POST['doctor'];
$receta = isset($_POST['receta']) ? 1 : 0; 

// Validar disponibilidad del doctor en la fecha y hora seleccionadas
$sql = "SELECT * FROM citas WHERE doctor = ? AND cita_dia = ? AND cita_hora = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $doctor, $citaDia, $citaHora);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El doctor ya tiene una cita programada en la fecha y hora seleccionadas
    echo "<script>alert('El doctor seleccionado ya tiene una cita programada para esa fecha y hora. Por favor, selecciona otra fecha u otro doctor.'); window.location='tu_formulario.php';</script>";
    exit();
}

// Insertar la cita en la base de datos si no hay conflictos
$sql_insert = "INSERT INTO citas (nombre, apellido_paterno, apellido_materno, correo, telefono, cita_dia, cita_hora, curp, especialidad, doctor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("sssssssssi", $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono, $citaDia, $citaHora, $curp, $especialidad, $doctor);

if ($stmt_insert->execute()) {
    // Cita agendada correctamente
    echo "<script>alert('Cita agendada correctamente.'); window.location='enviar_cita.php';</script>";
} else {
    // Error al insertar cita
    echo "<script>alert('Error al agendar la cita. Por favor, intenta nuevamente más tarde.'); window.location='cita.php';</script>";
}

$stmt_insert->close();
$conn->close();
?>
