<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

// TP N° 9 - Página con búsqueda en vivo (Fetch API + JSON)
$titulo_pagina = "Buscador de artículos";
$descripcion_pagina = "Buscá artículos de MedSalud sin recargar la página.";
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/clase5/funciones.php';

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categorias ORDER BY nombre")->fetchAll();

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>
<main class="container my-5">
  <h1>Buscador de artículos</h1>
  <p class="text-muted">Los resultados se actualizan mientras escribís, sin recargar la página.</p>

  <div class="row g-2 mb-2">
    <div class="col-md-8">
      <label for="inputBusqueda" class="visually-hidden">Buscar</label>
      <input type="search" id="inputBusqueda" class="form-control" placeholder="Ej: diabetes, desayuno..." autocomplete="off" maxlength="100">
    </div>
    <div class="col-md-4">
      <label for="selectCategoria" class="visually-hidden">Categoría</label>
      <select id="selectCategoria" class="form-select">
        <option value="">Todas las categorías</option>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= e($c['id_categoria']) ?>"><?= e($c['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <p id="estadoBusqueda" class="small text-muted mb-3" aria-live="polite"></p>

  <div id="resultados" class="row g-3"></div>
</main>
<script src="js/buscador.js" defer></script>
<?php require_once 'includes/footer.php'; ?>
