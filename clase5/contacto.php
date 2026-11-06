<?php
$titulo_pagina = "Contacto";
$descripcion_pagina = "Dejanos tu consulta y te orientamos.";
$ruta_base = '../';
require_once __DIR__ . '/funciones.php';

$errores = [];
$exito = false;
$nombre = $correo = $mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = trim((string) filter_input(INPUT_POST, 'nombre',  FILTER_UNSAFE_RAW));
    $correo  = trim((string) filter_input(INPUT_POST, 'correo',  FILTER_UNSAFE_RAW));
    $mensaje = trim((string) filter_input(INPUT_POST, 'mensaje', FILTER_UNSAFE_RAW));

    if ($nombre === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 60) {
        $errores['nombre'] = 'El nombre debe tener entre 2 y 60 caracteres.';
    }

    if ($correo === '') {
        $errores['correo'] = 'El correo es obligatorio.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = 'El formato del correo no es válido.';
    }

    if ($mensaje === '') {
        $errores['mensaje'] = 'El mensaje es obligatorio.';
    } elseif (mb_strlen($mensaje) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    }

    if (!$errores) {
        $exito = true;
        $enviado = ['nombre' => $nombre, 'correo' => $correo, 'mensaje' => $mensaje];
        $nombre = $correo = $mensaje = '';   // se limpian solo si fue exitoso
    }
}

require_once '../includes/header.php';
require_once '../includes/nav.php';
?>
<main class="container my-5">
  <h1>Contacto</h1>

  <?php if ($exito): ?>
    <div class="alert alert-success">
      ¡Gracias, <?= e($enviado['nombre']); ?>! Recibimos tu consulta.
      Te responderemos a <strong><?= e($enviado['correo']); ?></strong>.
    </div>
  <?php elseif ($errores): ?>
    <div class="alert alert-danger">Revisá los campos marcados.</div>
  <?php endif; ?>

  <form method="post" action="contacto.php" novalidate>
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre"
             class="form-control <?= isset($errores['nombre']) ? 'is-invalid' : ''; ?>"
             value="<?= e($nombre); ?>">
      <div class="invalid-feedback"><?= e($errores['nombre'] ?? ''); ?></div>
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo</label>
      <input type="text" id="correo" name="correo"
             class="form-control <?= isset($errores['correo']) ? 'is-invalid' : ''; ?>"
             value="<?= e($correo); ?>">
      <div class="invalid-feedback"><?= e($errores['correo'] ?? ''); ?></div>
    </div>
    <div class="mb-3">
      <label for="mensaje" class="form-label">Mensaje</label>
      <textarea id="mensaje" name="mensaje" rows="4"
                class="form-control <?= isset($errores['mensaje']) ? 'is-invalid' : ''; ?>"><?= e($mensaje); ?></textarea>
      <div class="invalid-feedback"><?= e($errores['mensaje'] ?? ''); ?></div>
    </div>
    <button type="submit" class="btn-medsalud">Enviar consulta</button>
  </form>
</main>
<?php require_once '../includes/footer.php'; ?>
