<?php
$ruta_base = '';
$titulo_pagina = 'Iniciar sesión';
$descripcion_pagina = 'Acceso a MedSalud.';

require_once __DIR__ . '/includes/sesion.php';
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/clase5/funciones.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');

    $stmt = $pdo->prepare(
        "SELECT u.id_usuario, u.nombre, u.password, r.nombre AS rol
         FROM usuarios u
         INNER JOIN roles r ON r.id_rol = u.id_rol
         WHERE u.email = :email AND u.activo = 1"
    );
    $stmt->execute([':email' => $email]);
    $u = $stmt->fetch();

    if ($u && password_verify($password, $u['password'])) {
        session_regenerate_id(true);                 // evita session fixation
        $_SESSION['usuario_id']     = (int) $u['id_usuario'];
        $_SESSION['usuario_nombre'] = $u['nombre'];
        $_SESSION['rol']            = $u['rol'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Email o contraseña incorrectos.';      // mensaje genérico a propósito
}

$avisos = [
    'acceso_denegado' => ['warning', 'Tenés que iniciar sesión para ver esa página.'],
];
$aviso = $avisos[$_GET['error'] ?? ''] ?? null;
if (($_GET['registro'] ?? '') === 'ok') $aviso = ['success', 'Cuenta creada. Ya podés iniciar sesión.'];
if (($_GET['logout'] ?? '') === 'ok')   $aviso = ['info', 'Cerraste sesión correctamente.'];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main class="container py-5" style="max-width: 480px;">
  <h1 class="mb-4">Iniciar sesión</h1>
  <?php if ($aviso): ?><div class="alert alert-<?= $aviso[0] ?>"><?= e($aviso[1]) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label" for="email">Email</label>
      <input class="form-control" id="email" name="email" type="email" value="<?= e($email) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label" for="password">Contraseña</label>
      <input class="form-control" id="password" name="password" type="password" required>
    </div>
    <button type="submit" class="btn-medsalud">Ingresar</button>
    <a href="registro.php" class="ms-3">Crear cuenta</a>
  </form>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
