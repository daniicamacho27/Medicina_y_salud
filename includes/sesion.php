<?php
// Inicia la sesión con cookie segura. Debe ejecutarse antes de cualquier salida HTML.
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => true,      // JS no puede leer la cookie
        'samesite' => 'Lax',
    ]);
    session_start();
}
