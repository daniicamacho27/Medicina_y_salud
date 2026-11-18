<?php
// Uso: definir $ruta_base y hacer require_once de este archivo ANTES de imprimir HTML.
require_once __DIR__ . '/sesion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ' . ($ruta_base ?? '') . 'login.php?error=acceso_denegado');
    exit;
}

/** Corta la ejecución con 403 si el usuario no tiene el rol pedido. */
function exigir_rol(string $rol): void
{
    if (($_SESSION['rol'] ?? '') !== $rol) {
        http_response_code(403);
        exit('403 · No tenés permisos para acceder a esta página.');
    }
}
