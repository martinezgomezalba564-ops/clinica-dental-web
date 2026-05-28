<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método no permitido.");
}

// LIMPIAR DATOS
function limpiar($dato) {
    return trim(strip_tags($dato));
}

function limpiarCabecera($valor) {
    return str_replace(["\r", "\n"], '', $valor);
}

// DATOS DEL FORMULARIO
$nombre          = limpiar($_POST["nombre"] ?? '');
$apellidos       = limpiar($_POST["apellidos"] ?? '');
$telefono        = limpiar($_POST["telefono"] ?? '');
$email           = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);
$mensaje         = limpiar($_POST["mensaje"] ?? '');
$via_respuesta   = limpiar($_POST["via_respuesta"] ?? '');
$privacidad      = $_POST["privacidad"] ?? '';

// VALIDACIÓN
if (
    !$nombre ||
    !$apellidos ||
    !$telefono ||
    !$email ||
    !$privacidad
) {
    http_response_code(400);
    exit("Faltan datos obligatorios o email inválido.");
}

// SEGURIDAD EMAIL
$email = limpiarCabecera($email);

// DESTINO
$destino = "clinica@tu-dominio.com";

// ASUNTO
$asunto = "Nueva solicitud de cita";

// CONTENIDO DEL EMAIL
$contenido = "Nueva solicitud de cita\n\n";

$contenido .= "Nombre: $nombre\n";
$contenido .= "Apellidos: $apellidos\n";
$contenido .= "Teléfono: $telefono\n";
$contenido .= "Email: $email\n";
$contenido .= "Vía de respuesta preferida: $via_respuesta\n";
$contenido .= "Mensaje:\n$mensaje\n";

// CABECERAS
$cabeceras  = "From: no-reply@tu-dominio.com\r\n";
$cabeceras .= "Reply-To: $email\r\n";
$cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

// ENVIAR EMAIL
$enviado = mail($destino, $asunto, $contenido, $cabeceras);

// RESPUESTA
if ($enviado) {
    echo "Solicitud enviada correctamente.";
} else {
    http_response_code(500);
    echo "Error al enviar la solicitud.";
}
?>

