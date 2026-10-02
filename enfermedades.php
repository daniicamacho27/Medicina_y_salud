<?php
$titulo_pagina = "Enfermedades";
$descripcion_pagina = "Síntomas frecuentes, factores de riesgo y orientación para conversar con profesionales de salud.";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main>
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="hero-eyebrow"><span class="rule"></span> Enfermedades</div>
          <div class="hero-index">02 — MEDSALUD</div>
          <h1 class="hero-title">Conocé para poder prevenir.</h1>
          <p class="hero-subtitle">Síntomas frecuentes, factores de riesgo y orientación para conversar con profesionales de salud.</p>
          <a href="mapa-del-sitio.php" class="btn-medsalud">Ver información</a><span class="hero-note">Consultá siempre a un profesional</span>
        </div>
        <div class="col-lg-6">
          <div class="hero-image-wrap">
            <img src="img/hero-stetoscopio.jpg" alt="Estetoscopio sobre una superficie de tela, representando la sección enfermedades" class="hero-image">
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>