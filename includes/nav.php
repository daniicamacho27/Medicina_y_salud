<?php
$pagina_actual = basename($_SERVER['PHP_SELF']);

function nav_class($archivo, $pagina_actual) {
    return $archivo === $pagina_actual ? 'nav-link active' : 'nav-link';
}
?>
<header class="navbar-medsalud">
  <nav class="navbar navbar-expand-lg container">
    <a class="navbar-brand" href="index.php"><span class="logo-dot">+</span> MedSalud</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Abrir menú">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navMain">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="<?= nav_class('index.php', $pagina_actual); ?>" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="<?= nav_class('medicina.php', $pagina_actual); ?>" href="medicina.php">Medicina</a></li>
        <li class="nav-item"><a class="<?= nav_class('enfermedades.php', $pagina_actual); ?>" href="enfermedades.php">Enfermedades</a></li>
        <li class="nav-item"><a class="<?= nav_class('sintomas.php', $pagina_actual); ?>" href="sintomas.php">Síntomas</a></li>
        <li class="nav-item"><a class="<?= nav_class('prevencion.php', $pagina_actual); ?>" href="prevencion.php">Prevención</a></li>
        <li class="nav-item"><a class="<?= nav_class('alimentacion-saludable.php', $pagina_actual); ?>" href="alimentacion-saludable.php">Alimentación saludable</a></li>
        <li class="nav-item"><a class="<?= nav_class('salud-mental.php', $pagina_actual); ?>" href="salud-mental.php">Salud mental</a></li>
        <li class="nav-item"><a class="<?= nav_class('actividad-fisica.php', $pagina_actual); ?>" href="actividad-fisica.php">Actividad física</a></li>
        <li class="nav-item"><a class="<?= nav_class('primeros-auxilios.php', $pagina_actual); ?>" href="primeros-auxilios.php">Primeros auxilios</a></li>
        <li class="nav-item"><a class="<?= nav_class('medicamentos.php', $pagina_actual); ?>" href="medicamentos.php">Medicamentos</a></li>
        <li class="nav-item"><a class="<?= nav_class('consejos.php', $pagina_actual); ?>" href="consejos.php">Consejos</a></li>
        <li class="nav-item"><a class="<?= nav_class('mapa-del-sitio.php', $pagina_actual); ?>" href="mapa-del-sitio.php">Mapa del sitio</a></li>
      </ul>
    </div>
  </nav>
</header>