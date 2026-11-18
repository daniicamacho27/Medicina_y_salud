<?php
// Conexión PDO a la base "medsalud" (TP6). Se incluye con require_once.
$host    = 'localhost';
$db      = 'medsalud';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // El detalle técnico va al log, no a la pantalla del visitante.
    error_log('Error de conexión: ' . $e->getMessage());
    http_response_code(500);
    die('No se pudo conectar con la base de datos. Verificá que MySQL esté iniciado.');
}
