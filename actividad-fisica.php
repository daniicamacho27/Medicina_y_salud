<?php
$titulo_pagina = "Movimiento";
$descripcion_pagina = "Propuestas para incorporar actividad física de manera segura y a tu ritmo.";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main>
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="hero-eyebrow"><span class="rule"></span> Movimiento</div>
          <div class="hero-index">07 — MEDSALUD</div>
          <h1 class="hero-title">Moverse es ganar salud.</h1>
          <p class="hero-subtitle">Propuestas para incorporar actividad física de manera segura y a tu ritmo.</p>
          <a href="mapa-del-sitio.php" class="btn-medsalud">Ver información</a><span class="hero-note">Cada movimiento suma</span>
        </div>
        <div class="col-lg-6">
          <div class="hero-image-wrap">
            <img src="img/hero-stetoscopio.jpg" alt="Estetoscopio sobre una superficie de tela, representando la sección actividad física" class="hero-image">
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>