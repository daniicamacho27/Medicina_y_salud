<?php
// VISTA: solo HTML + datos ya preparados por el controlador.
// Variables: $registros, $mensajes, $status
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/nav.php';
?>
<main class="container py-5">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h1 class="mb-0">Administración de artículos</h1>
    <a href="articulos.php?accion=crear" class="btn-medsalud">Agregar artículo</a>
  </div>

  <?php if (isset($mensajes[$status])): ?>
    <div class="alert alert-<?= e($mensajes[$status][0]) ?>" role="alert"><?= e($mensajes[$status][1]) ?></div>
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
              <a href="articulos.php?accion=editar&id=<?= e($item['id_articulo']) ?>" class="btn btn-sm btn-warning">Editar</a>
              <form action="articulos.php?accion=eliminar" method="post" class="d-inline"
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
<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
