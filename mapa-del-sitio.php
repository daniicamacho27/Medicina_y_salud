<?php
$titulo_pagina = "Mapa del sitio";
$descripcion_pagina = "Explorá todas las secciones de MedSalud desde un solo lugar.";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main>
  <section class="mapa-header">
    <div class="container d-flex justify-content-between align-items-end flex-wrap gap-3">
      <div>
        <div class="mapa-eyebrow">Mapa del sitio</div>
        <h1 class="mapa-title">Todo lo que necesitás para cuidar tu salud&hellip;</h1>
      </div>
      <p class="mapa-desc mb-0">Explorá cada tema a tu ritmo. Cada sección reúne información práctica y fuentes de confianza.</p>
    </div>
  </section>

  <section class="pb-5">
    <div class="container">
      <div class="row row-cols-1 row-cols-md-3 g-3">
        <div class="col"><a class="mapa-tile" href="index.php"><span class="num">00</span><span class="name">Inicio</span></a></div>
        <div class="col"><a class="mapa-tile" href="medicina.php"><span class="num">01</span><span class="name">Medicina</span></a></div>
        <div class="col"><a class="mapa-tile highlight-green" href="enfermedades.php"><span class="num">02</span><span class="name">Enfermedades</span></a></div>
        <div class="col"><a class="mapa-tile" href="sintomas.php"><span class="num">03</span><span class="name">Síntomas</span></a></div>
        <div class="col"><a class="mapa-tile" href="prevencion.php"><span class="num">04</span><span class="name">Prevención</span></a></div>
        <div class="col"><a class="mapa-tile" href="alimentacion-saludable.php"><span class="num">05</span><span class="name">Alimentación saludable</span></a></div>
        <div class="col"><a class="mapa-tile" href="salud-mental.php"><span class="num">06</span><span class="name">Salud mental</span></a></div>
        <div class="col"><a class="mapa-tile" href="actividad-fisica.php"><span class="num">07</span><span class="name">Actividad física</span></a></div>
        <div class="col"><a class="mapa-tile" href="primeros-auxilios.php"><span class="num">08</span><span class="name">Primeros auxilios</span></a></div>
        <div class="col"><a class="mapa-tile" href="medicamentos.php"><span class="num">09</span><span class="name">Medicamentos</span></a></div>
        <div class="col"><a class="mapa-tile highlight-terracotta" href="consejos.php"><span class="num">10</span><span class="name">Consejos de salud</span></a></div>
        <div class="col"><a class="mapa-tile" href="index.php#contacto"><span class="num">11</span><span class="name">Contacto</span></a></div>
      </div>
    </div>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>