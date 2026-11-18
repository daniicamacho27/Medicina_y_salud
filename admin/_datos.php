<?php
// Funciones compartidas por crear.php y editar.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../clase5/funciones.php'; // e() = htmlspecialchars

/** Listas para los <select> del formulario (FK de articulos). */
function cargar_listas(PDO $pdo): array
{
    return [
        'usuarios'   => $pdo->query("SELECT id_usuario AS id, CONCAT(nombre, ' ', apellido) AS nombre
                                     FROM usuarios WHERE activo = 1 ORDER BY apellido, nombre")->fetchAll(),
        'categorias' => $pdo->query("SELECT id_categoria AS id, nombre FROM categorias ORDER BY nombre")->fetchAll(),
        'estados'    => $pdo->query("SELECT id_estado AS id, nombre FROM estados_articulo ORDER BY id_estado")->fetchAll(),
    ];
}

/** Lee y limpia los datos que llegan por POST. */
function leer_formulario(): array
{
    return [
        'titulo'            => trim((string) ($_POST['titulo'] ?? '')),
        'resumen'           => trim((string) ($_POST['resumen'] ?? '')),
        'contenido'         => trim((string) ($_POST['contenido'] ?? '')),
        'id_usuario'        => trim((string) ($_POST['id_usuario'] ?? '')),
        'id_categoria'      => trim((string) ($_POST['id_categoria'] ?? '')),
        'id_estado'         => trim((string) ($_POST['id_estado'] ?? '')),
        'fecha_publicacion' => trim((string) ($_POST['fecha_publicacion'] ?? '')),
    ];
}

/** Validación en el servidor. Devuelve un array de errores (vacío = todo bien). */
function validar(array $d, array $listas): array
{
    $err = [];

    if ($d['titulo'] === '') {
        $err['titulo'] = 'El título es obligatorio.';
    } elseif (mb_strlen($d['titulo']) < 5 || mb_strlen($d['titulo']) > 150) {
        $err['titulo'] = 'El título debe tener entre 5 y 150 caracteres.';
    }

    if (mb_strlen($d['resumen']) > 255) {
        $err['resumen'] = 'El resumen no puede superar los 255 caracteres.';
    }

    if ($d['contenido'] === '') {
        $err['contenido'] = 'El contenido es obligatorio.';
    }

    foreach (['id_usuario' => 'usuarios', 'id_categoria' => 'categorias', 'id_estado' => 'estados'] as $campo => $lista) {
        $validos = array_map('strval', array_column($listas[$lista], 'id'));
        if (!in_array($d[$campo], $validos, true)) {
            $err[$campo] = 'Elegí una opción válida.';
        }
    }

    if ($d['fecha_publicacion'] !== '') {
        $f = DateTime::createFromFormat('Y-m-d', $d['fecha_publicacion']);
        if (!$f || $f->format('Y-m-d') !== $d['fecha_publicacion']) {
            $err['fecha_publicacion'] = 'La fecha no es válida.';
        }
    }

    return $err;
}
