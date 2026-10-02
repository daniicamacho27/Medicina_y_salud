<?php
$titulo_pagina = "Primeros auxilios";
$descripcion_pagina = "Pasos iniciales ante situaciones comunes y pautas claras para responder con calma.";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main>
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="hero-index">08 — MEDSALUD</div>
          <h1 class="hero-title">Saber actuar puede ayudar.</h1>
          <p class="hero-subtitle">Pasos iniciales ante situaciones comunes y pautas claras para responder con calma.</p>
          <a href="mapa-del-sitio.php" class="btn-medsalud">Ver información</a><span class="hero-note">Ante una urgencia, llamá a emergencias</span>
        </div>
        <div class="col-lg-6">
          <div class="hero-image-wrap">
            <img src="img/hero-stetoscopio.jpg" alt="Estetoscopio sobre una superficie de tela, representando la sección primeros auxilios" class="hero-image">
            <div class="hero-image-caption">La salud se construye con información clara, prevención y acompañamiento.</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>