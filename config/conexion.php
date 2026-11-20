<?php
// Conexión PDO. Se incluye con require_once y deja disponible $pdo.
// La lógica (Postgres en Vercel / MySQL local) está en config/medsalud_pdo.php.
require_once __DIR__ . '/medsalud_pdo.php';

try {
    $pdo = medsalud_pdo();
} catch (Throwable $e) {
    // El detalle técnico va al log, no a la pantalla del visitante.
    error_log('Error de conexión: ' . $e->getMessage());
    http_response_code(500);
    die('No se pudo conectar con la base de datos.');
}
