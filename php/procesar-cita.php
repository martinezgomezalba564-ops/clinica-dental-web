<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método no permitido.");
}

// LIMPIAR DATOS
function limpiar($dato) {
    return trim(strip_tags($dato));
}

// EVITAR INYECCIÓN EN CABECERAS
function limpiarCabecera($valor) {
    return str_replace(["\r", "\n"], '', $valor);
}

// DATOS DEL FORMULARIO
$nombre        = limpiar($_POST["nombre"] ?? '');
$apellidos     = limpiar($_POST["apellidos"] ?? '');
$telefono      = limpiar($_POST["telefono"] ?? '');
$email         = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);
$mensaje       = limpiar($_POST["mensaje"] ?? '');
$viaRespuesta  = limpiar($_POST["via_respuesta"] ?? '');
$privacidad    = $_POST["privacidad"] ?? '';

// VALIDACIÓN
if (
    !$nombre ||
    !$apellidos ||
    !$telefono ||
    !$email ||
    !$privacidad
) {
    http_response_code(400);
    exit("Faltan datos obligatorios o el email no es válido.");
}

// SEGURIDAD EMAIL
$email = limpiarCabecera($email);

// CORREO DE DESTINO
$destino = "ypaneva@gmail.com";

// ASUNTO
$asunto = "WEB. Nueva solicitud de cita - Clínica Dra. Pajares";

// CONTENIDO DEL EMAIL
$contenido = "Se ha recibido una nueva solicitud de cita.\n\n";
$contenido .= "Nombre: $nombre\n";
$contenido .= "Apellidos: $apellidos\n";
$contenido .= "Teléfono: $telefono\n";
$contenido .= "Email: $email\n";
$contenido .= "Vía de respuesta preferida: $viaRespuesta\n";
$contenido .= "Mensaje:\n";

if (!empty($mensaje)) {
    $contenido .= "$mensaje\n";
} else {
    $contenido .= "No especificado.\n";
}

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