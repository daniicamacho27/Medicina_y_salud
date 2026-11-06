<?php
$titulo_pagina = "Buscar";
$descripcion_pagina = "Buscá información en MedSalud.";
$ruta_base = '../';
require_once __DIR__ . '/funciones.php';

$catalogo = [
    ['titulo' => 'Medicina',               'url' => 'medicina.php',               'resumen' => 'Guías para comprender tu salud'],
    ['titulo' => 'Enfermedades',           'url' => 'enfermedades.php',           'resumen' => 'Información para detectar y prevenir'],
    ['titulo' => 'Síntomas',               'url' => 'sintomas.php',               'resumen' => 'Qué señales del cuerpo prestar atención'],
    ['titulo' => 'Prevención',             'url' => 'prevencion.php',             'resumen' => 'Hábitos y controles preventivos'],
    ['titulo' => 'Alimentación saludable', 'url' => 'alimentacion-saludable.php', 'resumen' => 'Elegí alimentos que te hagan bien'],
    ['titulo' => 'Salud mental',           'url' => 'salud-mental.php',           'resumen' => 'Cuidar la mente es cuidar la vida'],
    ['titulo' => 'Actividad física',       'url' => 'actividad-fisica.php',       'resumen' => 'Movimiento para tu día a día'],
    ['titulo' => 'Primeros auxilios',      'url' => 'primeros-auxilios.php',      'resumen' => 'Cómo actuar ante una emergencia'],
    ['titulo' => 'Medicamentos',           'url' => 'medicamentos.php',           'resumen' => 'Uso responsable de medicamentos'],
    ['titulo' => 'Consejos',               'url' => 'consejos.php',               'resumen' => 'Descanso, estrés y salud integral'],
];

$buscado = isset($_GET['q']);
$q = trim((string) filter_input(INPUT_GET, 'q', FILTER_UNSAFE_RAW));
$error = '';
$resultados = [];

if ($buscado) {
    if ($q === '') {
        $error = 'Escribí un término para buscar.';
    } elseif (mb_strlen($q) < 2) {
        $error = 'El término debe tener al menos 2 caracteres.';
    } else {
        foreach ($catalogo as $item) {
            if (mb_stripos($item['titulo'] . ' ' . $item['resumen'], $q) !== false) {
                $resultados[] = $item;
            }
        }
    }
}

require_once '../includes/header.php';
require_once '../includes/nav.php';
?>
<main class="container my-5">
  <h1>Buscar</h1>

  <form method="get" action="buscar.php" class="d-flex gap-2 mb-4">
    <input type="text" name="q" class="form-control" placeholder="Ej: alimentación"
           value="<?= e($q); ?>">
    <button type="submit" class="btn-medsalud">Buscar</button>
  </form>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= e($error); ?></div>
  <?php elseif ($buscado && !$resultados): ?>
    <div class="alert alert-warning">Sin resultados para «<?= e($q); ?>».</div>
  <?php elseif ($resultados): ?>
    <div class="alert alert-success"><?= count($resultados); ?> resultado(s) para «<?= e($q); ?>»:</div>
    <ul class="list-group">
      <?php foreach ($resultados as $r): ?>
        <li class="list-group-item">
          <a href="<?= e($ruta_base . $r['url']); ?>"><?= e($r['titulo']); ?></a>
          <small class="text-muted d-block"><?= e($r['resumen']); ?></small>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</main>
<?php require_once '../includes/footer.php'; ?>
