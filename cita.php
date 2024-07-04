<?php
     echo "<script>alert('¡No puedes realizar una cita dentro de 48 horas!');</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Proyecto de base de datos"/>
    <meta name="author" content="Veruete Hernandez Bryan David"/>
    <meta name="author" content="Tadeo Martínez Xiadani Alexahyatt "/>
    <meta name="author" content="Reyes León José Ramón "/>
    <meta name="keywords" content="HTML, CSS, JS, SQL, PHP"/>
    <title>Agendar citas</title>
</head>
<body>
    <h1>Agenda una cita</h1>
    <form action="enviar_cita.php" method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="Apellido_Paterno">Apellido Paterno:</label><br>
        <input type="text" id="Apellido_Paterno" name="Apellido_Paterno" required><br><br>
        
        <label for="Apellido_Materno">Apellido Materno:</label><br>
        <input type="text" id="Apellido_Materno" name="Apellido_Materno" required><br><br>
        
        <label for="correo">Correo:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>
        
        <label for="telefono">Telefono:</label><br>
        <input type="text" id="telefono" name="telefono" required><br><br>
        
        <label for="cita_dia">Dia:</label><br>
        <input type="date" id="cita_dia" name="cita_dia" required><br><br>
        
        <label for="cita_hora">Hora:</label><br>
        <input type="time" id="cita_hora" name="cita_hora" required><br><br>
        
        <label for="CURP">CURP:</label><br>
        <input type="text" id="CURP" name="CURP" required><br><br>

        <label for="especialidad">Especialidad:</label>
        <select name="especialidad" id="especialidad">
            <option value="">Selecciona una especialidad</option>
            <option value="cardiologia">Cardiología</option>
            <option value="traumatologia">Traumatología</option>
            <option value="cirugia">Cirugía</option>
            <option value="neurologia">Neurología</option>
            <option value="nutriologia">Nutriología</option>
            <option value="ginecologia">Ginecología</option>
            <option value="cirujano_plastico">Cirujano Plástico</option>
            <option value="medico_general">Médico General</option>
            <option value="ornitoralingologo">Otorrinolaringólogo</option>
            <option value="anestesiologia">Anestesiología</option>
        </select>
        <label for="Doctor">Doctor:</label>
        <select name="doctor" id="Doctor" disabled>
        <option value="">Selecciona un doctor</option>
            <!-- Opciones de doctor se añadirán dinámicamente -->
        </select>
        <script type="text/javascript" charset="utf-8">
            // Obtener referencia a los elementos select
            const especialidadSelect = document.getElementById('especialidad');
            const doctorSelect = document.getElementById('Doctor');
            // Opciones de doctores por especialidad
            const doctoresPorEspecialidad = {
                cardiologia: ["Juan Perez", "Ana Martinez", "Carlos Gomez", "1"],
                traumatologia: ["Pedro Sanchez", "Laura Fernandez", "2"],
                cirugia: ["Jorge Lopez", "Carmen Garcia", "3"],
                neurologia: ["Luis Ramirez", "4"],
                nutriologia: ["Sofia Gonzalez", "5"],
                ginecologia: ["Maria Rodriguez", "6"],
                cirujano_plastico: ["Pedro Sanchez", "7"],
                medico_general: ["Ana Martinez", "8"],
                ornitoralingologo: ["Carlos Gomez", "9"],
                anestesiologia: ["Sofia Gonzalez", "10"]
            };
            // Función para actualizar opciones de doctores según la especialidad seleccionada
            function actualizarDoctores() {
            // Obtener el valor seleccionado de especialidad
            const especialidadSeleccionada = especialidadSelect.value;
            // Limpiar opciones actuales de doctores
            doctorSelect.innerHTML = '<option value="">Selecciona un doctor</option>';
            // Si se selecciona una especialidad válida, añadir opciones correspondientes de doctores
            if (especialidadSeleccionada && doctoresPorEspecialidad[especialidadSeleccionada]) {
                doctoresPorEspecialidad[especialidadSeleccionada].forEach(function (doctor) {
                const option = document.createElement('option');
                option.textContent = doctor;
                option.value = doctor;
                doctorSelect.appendChild(option);
            });
            // Habilitar el select de doctores
            doctorSelect.disabled = false;
            } else {
            // Deshabilitar el select de doctores si no hay especialidad seleccionada
            doctorSelect.disabled = true;
            }
        }
        // Escuchar cambios en la especialidad seleccionada
        especialidadSelect.addEventListener('change', actualizarDoctores);
        // Llamar a la función inicialmente para establecer el estado inicial
        actualizarDoctores();
    </script>

    <script>
        // Obtener referencia a los elementos relevantes del formulario
        const citaDiaInput = document.getElementById('cita_dia');
        const citaHoraInput = document.getElementById('cita_hora');
        const submitButton = document.querySelector('input[type="submit"]');
        // Función para validar la fecha y hora seleccionadas
function validarFechaHora() {
    // Obtener la fecha y hora actuales
    const ahora = new Date();
    
    // Obtener la fecha y hora seleccionadas por el usuario
    const citaDia = new Date(citaDiaInput.value + 'T' + citaHoraInput.value);
    
    // Calcular la diferencia en milisegundos entre las fechas
    const diferenciaMilisegundos = citaDia.getTime() - ahora.getTime();
    
    // Convertir la diferencia a horas
    const diferenciaHoras = diferenciaMilisegundos / (1000 * 60 * 60);
    
    // Obtener el día actual
    const diaActual = ahora.getDate();
    const mesActual = ahora.getMonth() + 1; // Los meses van de 0 a 11, por lo que sumamos 1
    
    // Obtener el día de la cita seleccionada
    const diaCita = citaDia.getDate();
    const mesCita = citaDia.getMonth() + 1;
    
    // Validar que la fecha seleccionada no sea anterior a la fecha actual
    if (citaDia < ahora) {
        alert('¡No puedes seleccionar una fecha y hora que ya han pasado!');
        submitButton.disabled = true;
    } else if (diferenciaHoras <= 48) {
        alert('¡No puedes realizar una cita dentro de 48 horas!');
        submitButton.disabled = true;
    } else if (diaCita < diaActual && mesCita <= mesActual) {
        alert('¡No puedes realizar una cita en una fecha que ya ha pasado!');
        submitButton.disabled = true;
    } else {
        // Calcular la fecha límite para la cita (3 meses desde la fecha actual)
        const fechaLimite = new Date(ahora);
        fechaLimite.setMonth(fechaLimite.getMonth() + 3);
        
        // Validar que la fecha de la cita no sea mayor a 3 meses desde la fecha actual
        if (citaDia > fechaLimite) {
            alert('¡No se aceptan citas mayores a tres meses desde la fecha actual!');
            submitButton.disabled = true;
        } else {
            submitButton.disabled = false;
        }
    }
}

// Escuchar cambios en la fecha y hora seleccionadas
citaDiaInput.addEventListener('change', validarFechaHora);
citaHoraInput.addEventListener('change', validarFechaHora);

// Llamar a la función inicialmente para establecer el estado inicial
validarFechaHora();

</script>

        <br>
        <input type="submit" value="Agenda cita">
    </form>
</body>
</html>