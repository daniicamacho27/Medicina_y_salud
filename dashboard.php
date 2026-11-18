<?php
$ruta_base = '';
$titulo_pagina = 'Mi panel';
$descripcion_pagina = 'Panel del usuario.';

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/clase5/funciones.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main class="container py-5">
  <h1>Hola, <?= e($_SESSION['usuario_nombre']) ?></h1>
  <p>Tu rol es: <strong><?= e($_SESSION['rol']) ?></strong></p>
  <?php if ($_SESSION['rol'] === 'admin'): ?>
    <a class="btn-medsalud" href="admin_panel.php">Ir al panel de administración</a>
  <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
