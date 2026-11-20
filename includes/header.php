<?php
require_once __DIR__ . '/sesion.php';
if (is_file(__DIR__ . '/../config/env.php')) {
    require_once __DIR__ . '/../config/env.php';
} else { // despliegues sin env.php (Vercel): valores por defecto
    defined('APP_NOMBRE') || define('APP_NOMBRE', 'MedSalud');
    defined('APP_EMAIL_CONTACTO') || define('APP_EMAIL_CONTACTO', 'medsalud@info.ar');
    defined('APP_ENV') || define('APP_ENV', 'production');
}
$ruta_base = $ruta_base ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $titulo_pagina; ?> · MedSalud</title>
<meta name="description" content="<?= $descripcion_pagina; ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= $ruta_base; ?>css/styles.css">
</head>
<body>
