<?php
require_once __DIR__ . '/_guard.php';
// READ: listado de artículos
$ruta_base = '../';
$titulo_pagina = 'Administración';
$descripcion_pagina = 'Gestión de artículos de MedSalud.';

require_once __DIR__ . '/_datos.php';

$stmt = $pdo->prepare(
    "SELECT a.id_articulo, a.titulo, a.fecha_publicacion,
            CONCAT(u.nombre, ' ', u.apellido) AS autor,
            c.nombre AS categoria,
            es.nombre AS estado
     FROM articulos a
     INNER JOIN usuarios u          ON u.id_usuario   = a.id_usuario
     INNER JOIN categorias c        ON c.id_categoria = a.id_categoria
     INNER JOIN estados_articulo es ON es.id_estado   = a.id_estado
     ORDER BY a.id_articulo DESC"
);
$stmt->execute();
$registros = $stmt->fetchAll();

$mensajes = [
    'created'  => ['success', 'Artículo creado correctamente.'],
    'updated'  => ['success', 'Artículo actualizado correctamente.'],
    'deleted'  => ['success', 'Artículo eliminado correctamente.'],
    'notfound' => ['warning', 'El artículo solicitado no existe.'],
];
$status = $_GET['status'] ?? '';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<main class="container py-5">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h1 class="mb-0">Administración de artículos</h1>
    <a href="crear.php" class="btn-medsalud">Agregar artículo</a>
  </div>

  <?php if (isset($mensajes[$status])): ?>
    <div class="alert alert-<?= $mensajes[$status][0] ?>" role="alert"><?= e($mensajes[$status][1]) ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>ID</th><th>Título</th><th>Autor</th><th>Categoría</th><th>Estado</th><th>Publicación</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($registros)): ?>
          <tr><td colspan="7" class="text-center text-muted">Todavía no hay artículos cargados.</td></tr>
        <?php endif; ?>
        <?php foreach ($registros as $item): ?>
          <tr>
            <td><?= e($item['id_articulo']) ?></td>
            <td><?= e($item['titulo']) ?></td>
            <td><?= e($item['autor']) ?></td>
            <td><?= e($item['categoria']) ?></td>
            <td><?= e($item['estado']) ?></td>
            <td><?= e($item['fecha_publicacion'] ?? '—') ?></td>
            <td class="text-nowrap">
              <a href="editar.php?id=<?= e($item['id_articulo']) ?>" class="btn btn-sm btn-warning">Editar</a>
              <form action="eliminar.php" method="post" class="d-inline"
                    onsubmit="return confirm('¿Confirmás eliminar este artículo?')">
                <input type="hidden" name="id" value="<?= e($item['id_articulo']) ?>">
                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
