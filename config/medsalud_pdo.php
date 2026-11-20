<?php
// Fábrica de la conexión PDO (sin efectos secundarios: no hace die()).
//
// Orden de decisión:
//   1) Postgres (Vercel / Neon): DATABASE_URL, POSTGRES_URL o variables PG* / POSTGRES_*.
//   2) MySQL (XAMPP / Docker): DB_HOST, DB_NAME, DB_USER, DB_PASS (como antes).

/** Devuelve la conexión PDO (se crea una sola vez por request). */
function medsalud_pdo(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // Para Neon se prefiere la URL sin pooler (prepared statements reales sin sorpresas).
    $url = getenv('DATABASE_URL_UNPOOLED') ?: getenv('POSTGRES_URL_NON_POOLING')
        ?: getenv('DATABASE_URL') ?: getenv('POSTGRES_URL') ?: '';

    if ($url !== '') {
        $p = parse_url($url);
        if ($p === false || empty($p['host'])) {
            throw new RuntimeException('DATABASE_URL no tiene un formato válido.');
        }
        $host = $p['host'];
        $port = $p['port'] ?? 5432;
        $db   = ltrim($p['path'] ?? '', '/');
        $user = isset($p['user']) ? urldecode($p['user']) : '';
        $pass = isset($p['pass']) ? urldecode($p['pass']) : '';
    } elseif (getenv('PGHOST') || getenv('POSTGRES_HOST')) {
        $host = getenv('PGHOST') ?: getenv('POSTGRES_HOST');
        $port = getenv('PGPORT') ?: 5432;
        $db   = getenv('PGDATABASE') ?: getenv('POSTGRES_DATABASE') ?: 'neondb';
        $user = getenv('PGUSER') ?: getenv('POSTGRES_USER') ?: '';
        $pass = getenv('PGPASSWORD') ?: getenv('POSTGRES_PASSWORD') ?: '';
    } else {
        // MySQL (modo local, igual que antes)
        $host = getenv('DB_HOST') ?: 'localhost';
        $db   = getenv('DB_NAME') ?: 'medsalud';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
        return $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, $options);
    }

    $sslmode = getenv('DB_SSLMODE') ?: 'require';
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=$sslmode";
    return $pdo = new PDO($dsn, $user, $pass, $options);
}
