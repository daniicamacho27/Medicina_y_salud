<?php
require_once __DIR__ . '/includes/sesion.php';

session_unset();                                   // vacía $_SESSION
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

header('Location: login.php?logout=ok');
exit;
