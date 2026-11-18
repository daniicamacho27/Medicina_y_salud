<?php
// CREATE: formulario + inserción
$ruta_base = '../';
$titulo_pagina = 'Nuevo artículo';
$descripcion_pagina = 'Agregar un artículo a MedSalud.';

require_once __DIR__ . '/_datos.php';

$listas  = cargar_listas($pdo);
$errores = [];
$datos   = ['titulo' => '', 'resumen' => '', 'contenido' => '', 'id_usuario' => '',
            'id_categoria' => '', 'id_estado' => '', 'fecha_publicacion' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos   = leer_formulario();
    $errores = validar($datos, $listas);

    if (empty($errores)) {
        $sql = "INSERT INTO articulos
                    (id_usuario, id_categoria, id_estado, titulo, resumen, contenido, fecha_publicacion)
                VALUES
                    (:id_usuario, :id_categoria, :id_estado, :titulo, :resumen, :contenido, :fecha)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario'   => $datos['id_usuario'],
            ':id_categoria' => $datos['id_categoria'],
            ':id_estado'    => $datos['id_estado'],
            ':titulo'       => $datos['titulo'],
            ':resumen'      => $datos['resumen'] !== '' ? $datos['resumen'] : null,
            ':contenido'    => $datos['contenido'],
            ':fecha'        => $datos['fecha_publicacion'] !== '' ? $datos['fecha_publicacion'] : null,
        ]);

        header('Location: index.php?status=created');
        exit;
    }
}

$texto_boton = 'Guardar artículo';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<main class="container py-5" style="max-width: 820px;">
  <h1 class="mb-4">Nuevo artículo</h1>
  <?php require __DIR__ . '/_form.php'; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
