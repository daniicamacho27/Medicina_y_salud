<?php
$ruta_base = '../';
$titulo_pagina = "Contacto";
$descripcion_pagina = "Dejanos tu consulta y te orientamos hacia la sección o fuente de información que necesitás.";

require_once __DIR__ . '/funciones.php';

$nombre = '';
$correo = '';
$mensaje = '';
$errores = [];
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Sanitización de entradas
    $nombre  = trim((string) filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW));
    $correo  = trim((string) filter_input(INPUT_POST, 'correo', FILTER_UNSAFE_RAW));
    $mensaje = trim((string) filter_input(INPUT_POST, 'mensaje', FILTER_UNSAFE_RAW));

    // 2) Validación en servidor
    if ($nombre === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 60) {
        $errores['nombre'] = 'El nombre debe tener entre 2 y 60 caracteres.';
    }

    if ($correo === '') {
        $errores['correo'] = 'El correo es obligatorio.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = 'El correo no tiene un formato válido (ej: nombre@email.com).';
    }

    if ($mensaje === '') {
        $errores['mensaje'] = 'El mensaje es obligatorio.';
    } elseif (mb_strlen($mensaje) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    }

    // 3) Éxito: se vacían los campos. Si hay errores, se conservan (persistencia).
    if (empty($errores)) {
        $exito = true;
        $nombre_ok = $nombre;
        $nombre = $correo = $mensaje = '';
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<main class="container py-5" style="max-width: 760px;">
  <h1 class="mb-2">Contacto</h1>
  <p class="text-muted mb-4">Dejanos tu consulta y te orientamos hacia la sección o fuente de información que necesitás.</p>

  <?php if ($exito): ?>
    <div class="alert alert-success" role="alert">
      ¡Gracias, <?= e($nombre_ok) ?>! Recibimos tu consulta correctamente.
    </div>
  <?php elseif (!empty($errores)): ?>
    <div class="alert alert-danger" role="alert">
      <strong>No pudimos enviar el formulario.</strong> Revisá los siguientes campos:
      <ul class="mb-0 mt-2">
        <?php foreach ($errores as $error): ?>
          <li><?= e($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="contacto.php" method="post" novalidate>
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre"
             class="form-control<?= isset($errores['nombre']) ? ' is-invalid' : '' ?>"
             value="<?= e($nombre) ?>" placeholder="Tu nombre">
      <?php if (isset($errores['nombre'])): ?>
        <div class="invalid-feedback"><?= e($errores['nombre']) ?></div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label for="correo" class="form-label">Correo</label>
      <input type="email" id="correo" name="correo"
             class="form-control<?= isset($errores['correo']) ? ' is-invalid' : '' ?>"
             value="<?= e($correo) ?>" placeholder="nombre@email.com">
      <?php if (isset($errores['correo'])): ?>
        <div class="invalid-feedback"><?= e($errores['correo']) ?></div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label for="mensaje" class="form-label">Mensaje</label>
      <textarea id="mensaje" name="mensaje" rows="4"
                class="form-control<?= isset($errores['mensaje']) ? ' is-invalid' : '' ?>"
                placeholder="¿En qué podemos ayudarte?"><?= e($mensaje) ?></textarea>
      <?php if (isset($errores['mensaje'])): ?>
        <div class="invalid-feedback"><?= e($errores['mensaje']) ?></div>
      <?php endif; ?>
    </div>

    <button type="submit" class="btn-medsalud">Enviar consulta</button>
  </form>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
