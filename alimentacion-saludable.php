<?php
$titulo_pagina = "Nutrición";
$descripcion_pagina = "Ideas prácticas para armar una alimentación variada, posible y nutritiva.";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main>
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="hero-eyebrow"><span class="rule"></span> Nutrición</div>
          <div class="hero-index">05 — MEDSALUD</div>
          <h1 class="hero-title">Comer bien se siente bien.</h1>
          <p class="hero-subtitle">Ideas prácticas para armar una alimentación variada, posible y nutritiva.</p>
          <a href="mapa-del-sitio.php" class="btn-medsalud">Ver información</a><span class="hero-note">Nutrición sin extremos</span>
        </div>
        <div class="col-lg-6">
          <div class="hero-image-wrap">
            <img src="img/hero-stetoscopio.jpg" alt="Estetoscopio sobre una superficie de tela, representando la sección nutrición" class="hero-image">
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>