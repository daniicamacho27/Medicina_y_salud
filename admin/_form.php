<?php
// Formulario compartido por crear.php y editar.php.
// Variables esperadas: $datos, $errores, $listas, $texto_boton
function opciones(array $lista, string $seleccionado): void
{
    foreach ($lista as $o) {
        $sel = ((string) $o['id'] === $seleccionado) ? ' selected' : '';
        echo '<option value="' . e($o['id']) . '"' . $sel . '>' . e($o['nombre']) . '</option>';
    }
}
function clase_error(array $errores, string $campo): string
{
    return isset($errores[$campo]) ? ' is-invalid' : '';
}
?>
<?php if (!empty($errores)): ?>
  <div class="alert alert-danger" role="alert">
    <strong>No se pudo guardar.</strong> Revisá los campos marcados.
  </div>
<?php endif; ?>

<form method="post" novalidate>
  <?php if (isset($datos['id_articulo'])): ?>
    <input type="hidden" name="id" value="<?= e($datos['id_articulo']) ?>">
  <?php endif; ?>

  <div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input type="text" id="titulo" name="titulo" maxlength="150"
           class="form-control<?= clase_error($errores, 'titulo') ?>" value="<?= e($datos['titulo']) ?>">
    <?php if (isset($errores['titulo'])): ?><div class="invalid-feedback"><?= e($errores['titulo']) ?></div><?php endif; ?>
  </div>

  <div class="mb-3">
    <label for="resumen" class="form-label">Resumen <span class="text-muted">(opcional)</span></label>
    <input type="text" id="resumen" name="resumen" maxlength="255"
           class="form-control<?= clase_error($errores, 'resumen') ?>" value="<?= e($datos['resumen']) ?>">
    <?php if (isset($errores['resumen'])): ?><div class="invalid-feedback"><?= e($errores['resumen']) ?></div><?php endif; ?>
  </div>

  <div class="mb-3">
    <label for="contenido" class="form-label">Contenido</label>
    <textarea id="contenido" name="contenido" rows="6"
              class="form-control<?= clase_error($errores, 'contenido') ?>"><?= e($datos['contenido']) ?></textarea>
    <?php if (isset($errores['contenido'])): ?><div class="invalid-feedback"><?= e($errores['contenido']) ?></div><?php endif; ?>
  </div>

  <div class="row">
    <div class="col-md-4 mb-3">
      <label for="id_usuario" class="form-label">Autor</label>
      <select id="id_usuario" name="id_usuario" class="form-select<?= clase_error($errores, 'id_usuario') ?>">
        <option value="">Elegir...</option>
        <?php opciones($listas['usuarios'], (string) $datos['id_usuario']); ?>
      </select>
      <?php if (isset($errores['id_usuario'])): ?><div class="invalid-feedback"><?= e($errores['id_usuario']) ?></div><?php endif; ?>
    </div>
    <div class="col-md-4 mb-3">
      <label for="id_categoria" class="form-label">Categoría</label>
      <select id="id_categoria" name="id_categoria" class="form-select<?= clase_error($errores, 'id_categoria') ?>">
        <option value="">Elegir...</option>
        <?php opciones($listas['categorias'], (string) $datos['id_categoria']); ?>
      </select>
      <?php if (isset($errores['id_categoria'])): ?><div class="invalid-feedback"><?= e($errores['id_categoria']) ?></div><?php endif; ?>
    </div>
    <div class="col-md-4 mb-3">
      <label for="id_estado" class="form-label">Estado</label>
      <select id="id_estado" name="id_estado" class="form-select<?= clase_error($errores, 'id_estado') ?>">
        <option value="">Elegir...</option>
        <?php opciones($listas['estados'], (string) $datos['id_estado']); ?>
      </select>
      <?php if (isset($errores['id_estado'])): ?><div class="invalid-feedback"><?= e($errores['id_estado']) ?></div><?php endif; ?>
    </div>
  </div>

  <div class="mb-4" style="max-width: 240px;">
    <label for="fecha_publicacion" class="form-label">Fecha de publicación <span class="text-muted">(opcional)</span></label>
    <input type="date" id="fecha_publicacion" name="fecha_publicacion"
           class="form-control<?= clase_error($errores, 'fecha_publicacion') ?>" value="<?= e($datos['fecha_publicacion']) ?>">
    <?php if (isset($errores['fecha_publicacion'])): ?><div class="invalid-feedback"><?= e($errores['fecha_publicacion']) ?></div><?php endif; ?>
  </div>

  <button type="submit" class="btn-medsalud"><?= e($texto_boton) ?></button>
  <a href="index.php" class="btn btn-link">Cancelar</a>
</form>
