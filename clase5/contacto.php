<?php
$ruta_base = '../';
$titulo_pagina = "Buscar";
$descripcion_pagina = "Buscá información en las secciones de MedSalud.";

require_once __DIR__ . '/funciones.php';

// Catálogo de secciones del sitio
$catalogo = [
    ['titulo' => 'Medicina',               'archivo' => 'medicina.php',               'desc' => 'Guías sobre consultas, estudios médicos y el funcionamiento del organismo.'],
    ['titulo' => 'Enfermedades',           'archivo' => 'enfermedades.php',           'desc' => 'Información para detectar y prevenir enfermedades frecuentes.'],
    ['titulo' => 'Síntomas',               'archivo' => 'sintomas.php',               'desc' => 'Cómo interpretar las señales del cuerpo y cuándo consultar.'],
    ['titulo' => 'Prevención',             'archivo' => 'prevencion.php',             'desc' => 'Hábitos, controles y vacunas para cuidar tu salud.'],
    ['titulo' => 'Alimentación saludable', 'archivo' => 'alimentacion-saludable.php', 'desc' => 'Elegí alimentos que te hagan bien.'],
    ['titulo' => 'Salud mental',           'archivo' => 'salud-mental.php',           'desc' => 'Cuidar la mente es cuidar la vida.'],
    ['titulo' => 'Actividad física',       'archivo' => 'actividad-fisica.php',       'desc' => 'Movimiento y ejercicio para el bienestar cotidiano.'],
    ['titulo' => 'Primeros auxilios',      'archivo' => 'primeros-auxilios.php',      'desc' => 'Qué hacer ante una emergencia hasta que llegue la ayuda.'],
    ['titulo' => 'Medicamentos',           'archivo' => 'medicamentos.php',           'desc' => 'Uso responsable de los medicamentos.'],
    ['titulo' => 'Consejos',               'archivo' => 'consejos.php',               'desc' => 'Recomendaciones simples para el día a día.'],
    ['titulo' => 'Mapa del sitio',         'archivo' => 'mapa-del-sitio.php',         'desc' => 'Todas las secciones de MedSalud en un solo lugar.'],
];

$q = '';
$error = '';
$resultados = [];
$buscado = false;

// El formulario GET envía el parámetro "q". isset() detecta si se envió.
if (isset($_GET['q'])) {
    $buscado = true;
    $q = trim((string) filter_input(INPUT_GET, 'q', FILTER_UNSAFE_RAW));

    if ($q === '') {
        $error = 'Escribí un término para buscar.';
    } elseif (mb_strlen($q) < 2) {
        $error = 'El término debe tener al menos 2 caracteres.';
    } else {
        foreach ($catalogo as $item) {
            if (mb_stripos($item['titulo'], $q) !== false || mb_stripos($item['desc'], $q) !== false) {
                $resultados[] = $item;
            }
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<main class="container py-5" style="max-width: 760px;">
  <h1 class="mb-2">Buscar en MedSalud</h1>
  <p class="text-muted mb-4">Encontrá rápidamente la sección que necesitás.</p>

  <form action="buscar.php" method="get" class="row g-2 mb-4" novalidate>
    <div class="col-sm-9">
      <label for="q" class="visually-hidden">Término de búsqueda</label>
      <input type="search" id="q" name="q"
             class="form-control<?= $error !== '' ? ' is-invalid' : '' ?>"
             value="<?= e($q) ?>" placeholder="Ej: salud, alimentación, síntomas">
      <?php if ($error !== ''): ?>
        <div class="invalid-feedback"><?= e($error) ?></div>
      <?php endif; ?>
    </div>
    <div class="col-sm-3 d-grid">
      <button type="submit" class="btn-medsalud">Buscar</button>
    </div>
  </form>

  <?php if ($buscado && $error === ''): ?>
    <?php if (!empty($resultados)): ?>
      <div class="alert alert-success" role="alert">
        Se encontraron <strong><?= count($resultados) ?></strong> resultado(s) para “<?= e($q) ?>”.
      </div>
      <div class="list-group">
        <?php foreach ($resultados as $r): ?>
          <a class="list-group-item list-group-item-action" href="<?= e($ruta_base . $r['archivo']) ?>">
            <strong><?= e($r['titulo']) ?></strong><br>
            <small class="text-muted"><?= e($r['desc']) ?></small>
          </a>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-warning" role="alert">
        No se encontraron resultados para “<?= e($q) ?>”. Probá con otro término.
      </div>
    <?php endif; ?>
  <?php elseif ($buscado && $error !== ''): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
  <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
