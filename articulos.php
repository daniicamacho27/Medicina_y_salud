<?php
// FRONT CONTROLLER del módulo Artículos (MVC nativo, TP N° 10 - Parte A).
// Uso: articulos.php?accion=listar | crear | editar&id=1 | eliminar (POST)
$ruta_base = '';
require_once __DIR__ . '/includes/auth_guard.php';
exigir_rol('admin');

require_once __DIR__ . '/config/conexion.php';          // define $pdo
require_once __DIR__ . '/clase5/funciones.php';         // e() = htmlspecialchars
require_once __DIR__ . '/app/Models/ArticuloModel.php';
require_once __DIR__ . '/app/Controllers/ArticuloController.php';

$controlador = new ArticuloController(new ArticuloModel($pdo));

$accion = $_GET['accion'] ?? 'listar';
if (!in_array($accion, ['listar', 'crear', 'editar', 'eliminar'], true)) {
    http_response_code(404);
    exit('404 · Acción no encontrada.');
}

$controlador->$accion();
