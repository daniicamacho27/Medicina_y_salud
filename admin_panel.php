<?php
$ruta_base = '';
$titulo_pagina = 'Panel de administración';
$descripcion_pagina = 'Gestión de usuarios (solo administradores).';

require_once __DIR__ . '/includes/auth_guard.php';
exigir_rol('admin');
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/clase5/funciones.php';

$usuarios = $pdo->query(
    "SELECT u.id_usuario, u.nombre, u.apellido, u.email, r.nombre AS rol, u.created_at
     FROM usuarios u INNER JOIN roles r ON r.id_rol = u.id_rol
     ORDER BY u.created_at DESC"
)->fetchAll();

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main class="container py-5">
  <h1 class="mb-4">Panel de administración</h1>
  <a class="btn-medsalud mb-4 d-inline-block" href="admin/index.php">Gestionar artículos</a>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Alta</th></tr></thead>
      <tbody>
      <?php foreach ($usuarios as $u): ?>
        <tr>
          <td><?= e($u['id_usuario']) ?></td>
          <td><?= e($u['nombre'] . ' ' . $u['apellido']) ?></td>
          <td><?= e($u['email']) ?></td>
          <td><?= e($u['rol']) ?></td>
          <td><?= e($u['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
