<?php
require_once __DIR__ . '/_guard.php';
// UPDATE: carga el registro, muestra el formulario y actualiza
$ruta_base = '../';
$titulo_pagina = 'Editar artículo';
$descripcion_pagina = 'Modificar un artículo de MedSalud.';

require_once __DIR__ . '/_datos.php';

$id = filter_var($_POST['id'] ?? $_GET['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php?status=notfound');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articulos WHERE id_articulo = :id");
$stmt->execute([':id' => $id]);
$articulo = $stmt->fetch();
if (!$articulo) {
    header('Location: index.php?status=notfound');
    exit;
}

$listas  = cargar_listas($pdo);
$errores = [];
$datos   = [
    'id_articulo'       => $articulo['id_articulo'],
    'titulo'            => $articulo['titulo'],
    'resumen'           => $articulo['resumen'] ?? '',
    'contenido'         => $articulo['contenido'],
    'id_usuario'        => $articulo['id_usuario'],
    'id_categoria'      => $articulo['id_categoria'],
    'id_estado'         => $articulo['id_estado'],
    'fecha_publicacion' => $articulo['fecha_publicacion'] ?? '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos   = leer_formulario() + ['id_articulo' => $id];
    $errores = validar($datos, $listas);

    if (empty($errores)) {
        $sql = "UPDATE articulos
                SET id_usuario = :id_usuario, id_categoria = :id_categoria, id_estado = :id_estado,
                    titulo = :titulo, resumen = :resumen, contenido = :contenido,
                    fecha_publicacion = :fecha
                WHERE id_articulo = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario'   => $datos['id_usuario'],
            ':id_categoria' => $datos['id_categoria'],
            ':id_estado'    => $datos['id_estado'],
            ':titulo'       => $datos['titulo'],
            ':resumen'      => $datos['resumen'] !== '' ? $datos['resumen'] : null,
            ':contenido'    => $datos['contenido'],
            ':fecha'        => $datos['fecha_publicacion'] !== '' ? $datos['fecha_publicacion'] : null,
            ':id'           => $id,
        ]);

        header('Location: index.php?status=updated');
        exit;
    }
}

$texto_boton = 'Guardar cambios';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<main class="container py-5" style="max-width: 820px;">
  <h1 class="mb-4">Editar artículo #<?= e($id) ?></h1>
  <?php require __DIR__ . '/_form.php'; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
