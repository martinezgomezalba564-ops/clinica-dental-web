<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método no permitido.");
}

// Limpiar datos
function limpiar($dato) {
    return trim(strip_tags($dato));
}

// Evitar inyección en cabeceras
function limpiarCabecera($valor) {
    return str_replace(["\r", "\n"], '', $valor);
}

// DATOS DEL FORMULARIO
$nombre   = limpiar($_POST["nombre"] ?? '');
$telefono = limpiar($_POST["telefono"] ?? '');
$email    = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);
$fecha    = limpiar($_POST["fecha"] ?? '');
$hora     = limpiar($_POST["hora"] ?? '');
$mensaje  = limpiar($_POST["mensaje"] ?? '');

// VALIDACIÓN
if (!$nombre || !$telefono || !$email || !$fecha || !$hora) {
    http_response_code(400);
    exit("Faltan datos obligatorios o el email no es válido.");
}

$email = limpiarCabecera($email);

// CORREO DE LA CLÍNICA
$destino = "ypaneva@gmail.com";

// ASUNTO DEL CORREO
$asunto = "Solicitud de cancelación de cita - Clínica Dental";

// CONTENIDO DEL MENSAJE
$contenido = "Se ha recibido una nueva solicitud de cancelación de cita.\n\n";
$contenido .= "Nombre: $nombre\n";
$contenido .= "Teléfono: $telefono\n";
$contenido .= "Email: $email\n";
$contenido .= "Fecha de la cita: $fecha\n";
$contenido .= "Hora de la cita: $hora\n";
$contenido .= "Motivo: $mensaje\n";

// CABECERAS
$cabeceras  = "From: no-reply@clinicadrapajares.com\r\n";
$cabeceras .= "Reply-To: $email\r\n";
$cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

// ENVÍO
if (mail($destino, $asunto, $contenido, $cabeceras)) {
    echo "Solicitud enviada correctamente.";
} else {
    http_response_code(500);
    echo "Error al enviar la solicitud.";
}
?>