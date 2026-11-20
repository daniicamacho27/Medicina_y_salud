<?php
$ruta_base = '';
$titulo_pagina = 'Crear cuenta';
$descripcion_pagina = 'Registro de usuarios de MedSalud.';

require_once __DIR__ . '/includes/sesion.php';
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/clase5/funciones.php';

$errores = [];
$datos   = ['nombre' => '', 'apellido' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['nombre']   = trim((string) ($_POST['nombre'] ?? ''));
    $datos['apellido'] = trim((string) ($_POST['apellido'] ?? ''));
    $datos['email']    = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password  = (string) ($_POST['password'] ?? '');
    $password2 = (string) ($_POST['password2'] ?? '');

    foreach (['nombre', 'apellido'] as $campo) {
        if (!preg_match("/^[\p{L}' -]{2,60}$/u", $datos[$campo])) {
            $errores[$campo] = 'Usá solo letras (2 a 60 caracteres).';
        }
    }
    if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($datos['email']) > 120) {
        $errores['email'] = 'Ingresá un email válido.';
    }
    if (strlen($password) < 8 || strlen($password) > 72) { // bcrypt solo usa 72 bytes
        $errores['password'] = 'La contraseña debe tener entre 8 y 72 caracteres.';
    } elseif ($password !== $password2) {
        $errores['password2'] = 'Las contraseñas no coinciden.';
    }

    // El email no debe existir
    if (!$errores) {
        $stmt = $pdo->prepare('SELECT 1 FROM usuarios WHERE email = :email');
        $stmt->execute([':email' => $datos['email']]);
        if ($stmt->fetchColumn()) {
            $errores['email'] = 'Ese email ya está registrado.';
        }
    }

    if (!$errores) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO usuarios (id_rol, nombre, apellido, email, password)
                 VALUES ((SELECT id_rol FROM roles WHERE nombre = 'usuario'),
                         :nombre, :apellido, :email, :password)"
            );
            $stmt->execute([
                ':nombre'   => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                ':email'    => $datos['email'],
                ':password' => $hash,
            ]);
            header('Location: login.php?registro=ok');
            exit;
        } catch (PDOException $ex) {
            if (in_array((string) $ex->getCode(), ['23000', '23505'], true)) {
                $errores['email'] = 'Ese email ya está registrado.';
            } else {
                error_log('Registro: ' . $ex->getMessage());
                $errores['general'] = 'No pudimos crear la cuenta. Intentá de nuevo.';
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';

$campos = [
    'nombre'    => ['Nombre', 'text', 'given-name'],
    'apellido'  => ['Apellido', 'text', 'family-name'],
    'email'     => ['Email', 'email', 'email'],
    'password'  => ['Contraseña', 'password', 'new-password'],
    'password2' => ['Repetir contraseña', 'password', 'new-password'],
];
?>
<main class="container py-5" style="max-width: 520px;">
  <h1 class="mb-4">Crear cuenta</h1>

  <?php if (isset($errores['general'])): ?>
    <div class="alert alert-danger"><?= e($errores['general']) ?></div>
  <?php endif; ?>

  <form method="post" novalidate>
    <?php foreach ($campos as $name => [$label, $type, $auto]): ?>
      <div class="mb-3">
        <label class="form-label" for="<?= $name ?>"><?= $label ?></label>
        <input class="form-control<?= isset($errores[$name]) ? ' is-invalid' : '' ?>"
               id="<?= $name ?>" name="<?= $name ?>" type="<?= $type ?>"
               autocomplete="<?= $auto ?>" required
               value="<?= $type === 'password' ? '' : e($datos[$name]) ?>">
        <?php if (isset($errores[$name])): ?>
          <div class="invalid-feedback"><?= e($errores[$name]) ?></div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
    <button type="submit" class="btn-medsalud">Registrarme</button>
    <a href="login.php" class="ms-3">Ya tengo cuenta</a>
  </form>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
