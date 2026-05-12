<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método no permitido.");
}

function limpiar($dato) {
    return trim(strip_tags($dato));
}

function limpiarCabecera($valor) {
    return str_replace(["\r", "\n"], '', $valor);
}

// DATOS
$nombre   = limpiar($_POST["nombre"] ?? '');
$telefono = limpiar($_POST["telefono"] ?? '');
$email    = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);
$fecha    = limpiar($_POST["fecha"] ?? '');
$hora     = limpiar($_POST["hora"] ?? '');
$mensaje  = limpiar($_POST["mensaje"] ?? '');

// VALIDACIÓN
if (!$nombre || !$telefono || !$email || !$fecha || !$hora) {
    http_response_code(400);
    exit("Faltan datos obligatorios o email inválido.");
}

$email = limpiarCabecera($email);

// DESTINO
$destino = "clinica@tu-dominio.com";

// ASUNTO
$asunto = "Solicitud de cancelación de cita";

// MENSAJE
$contenido = "Nueva solicitud de cancelación de cita\n\n";
$contenido .= "Nombre: $nombre\n";
$contenido .= "Teléfono: $telefono\n";
$contenido .= "Email: $email\n";
$contenido .= "Fecha: $fecha\n";
$contenido .= "Hora: $hora\n";
$contenido .= "Motivo: $mensaje\n";

// CABECERAS
$cabeceras  = "From: no-reply@tu-dominio.com\r\n";
$cabeceras .= "Reply-To: $email\r\n";
$cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

// ENVIAR
$enviado = mail($destino, $asunto, $contenido, $cabeceras);

// RESPUESTA
if ($enviado) {
    echo "OK";
} else {
    http_response_code(500);
    echo "Error al enviar la solicitud.";
}
?>