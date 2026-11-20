<?php
// Inicia la sesión con cookie segura. Debe ejecutarse antes de cualquier salida HTML.
//
// En Vercel cada request puede correr en una instancia distinta y /tmp no se comparte,
// así que con Postgres las sesiones se guardan en la tabla `sessions`.
// Con MySQL (XAMPP / Docker) se mantienen las sesiones por archivo de siempre.

if (session_status() === PHP_SESSION_NONE) {
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,      // JS no puede leer la cookie
        'samesite' => 'Lax',
    ]);

    // Solo si hay una base Postgres configurada. Si falla la conexión, se usan sesiones
    // por archivo para no tumbar las páginas que no necesitan la base.
    require_once __DIR__ . '/../config/medsalud_pdo.php';
    if (getenv('DATABASE_URL') || getenv('DATABASE_URL_UNPOOLED') || getenv('POSTGRES_URL')
        || getenv('PGHOST') || getenv('POSTGRES_HOST')) {
        try {
            require_once __DIR__ . '/SesionPostgres.php';
            session_set_save_handler(new SesionPostgres(medsalud_pdo()), true);
        } catch (Throwable $e) {
            error_log('Sesiones en Postgres no disponibles: ' . $e->getMessage());
        }
    }
    session_start();
}
