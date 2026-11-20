<?php
$pagina_actual = basename($_SERVER['PHP_SELF']);

$menu = [
    'index.php'                  => 'Inicio',
    'medicina.php'               => 'Medicina',
    'enfermedades.php'           => 'Enfermedades',
    'sintomas.php'               => 'Síntomas',
    'prevencion.php'             => 'Prevención',
    'alimentacion-saludable.php' => 'Alimentación saludable',
    'salud-mental.php'           => 'Salud mental',
    'actividad-fisica.php'       => 'Actividad física',
    'primeros-auxilios.php'      => 'Primeros auxilios',
    'medicamentos.php'           => 'Medicamentos',
    'consejos.php'               => 'Consejos',
    'mapa-del-sitio.php'         => 'Mapa del sitio',
    'clase5/contacto.php'        => 'Contacto',
    'clase5/buscar.php'          => 'Buscar',
    'buscador.php'               => 'Buscador en vivo',
];
?>
<header class="navbar-medsalud">
  <nav class="navbar navbar-expand-lg container">
    <a class="navbar-brand" href="<?= $ruta_base; ?>index.php"><span class="logo-dot">+</span> MedSalud</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Abrir menú">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navMain">
      <ul class="navbar-nav">
        <?php foreach ($menu as $archivo => $texto): ?>
          <li class="nav-item">
            <a class="nav-link<?= basename($archivo) === $pagina_actual ? ' active' : ''; ?>" href="<?= $ruta_base . $archivo; ?>"><?= $texto; ?></a>
          </li>
        <?php endforeach; ?>
        <?php if (isset($_SESSION['usuario_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= $ruta_base ?>dashboard.php">Hola, <?= htmlspecialchars($_SESSION['usuario_nombre'], ENT_QUOTES, 'UTF-8') ?></a></li>
        <?php if (($_SESSION['rol'] ?? '') === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= $ruta_base ?>admin_panel.php">Admin</a></li>
        <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="<?= $ruta_base ?>logout.php">Salir</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= $ruta_base ?>login.php">Ingresar</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $ruta_base ?>registro.php">Crear cuenta</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>
