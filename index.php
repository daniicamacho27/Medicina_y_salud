<?php
$titulo_pagina = "Inicio";
$descripcion_pagina = "Información médica confiable para entender tu cuerpo, tomar decisiones informadas y cuidar tu salud día a día.";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main>
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="hero-eyebrow"><span class="rule"></span> Salud para todos los días</div>
          <div class="hero-index">00 — MEDSALUD</div>
          <h1 class="hero-title">Cuidá tu salud, cuidá tu vida.</h1>
          <p class="hero-subtitle">Información médica confiable para entender tu cuerpo, tomar decisiones informadas y cuidar tu salud día a día.</p>
          <a href="mapa-del-sitio.php" class="btn-medsalud">Ver información</a>
        </div>
        <div class="col-lg-6">
          <div class="hero-image-wrap">
            <img src="img/hero-inicio.jpg" alt="Profesional de la salud con estetoscopio revisando un teléfono" class="hero-image">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="destacados-section">
    <div class="container">
      <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
        <h2 class="destacados-title">Para vivir mejor, hoy.</h2>
        <span class="destacados-meta">04 áreas esenciales</span>
      </div>
      <div class="row g-0 border-top border-start">
        <div class="col-md-6 border-end border-bottom">
          <a href="medicina.php" class="destacado-card d-block text-decoration-none">
            <span class="num">01</span>
            <span class="arrow">&#8599;</span>
            <h3>Medicina</h3>
            <p>Guías para comprender tu salud</p>
          </a>
        </div>
        <div class="col-md-6 border-end border-bottom">
          <a href="enfermedades.php" class="destacado-card d-block text-decoration-none">
            <span class="num">02</span>
            <span class="arrow">&#8599;</span>
            <h3>Enfermedades</h3>
            <p>Información para detectar y prevenir</p>
          </a>
        </div>
        <div class="col-md-6 border-end border-bottom">
          <a href="alimentacion-saludable.php" class="destacado-card d-block text-decoration-none">
            <span class="num">05</span>
            <span class="arrow">&#8599;</span>
            <h3>Alimentación</h3>
            <p>Elegí alimentos que te hagan bien</p>
          </a>
        </div>
        <div class="col-md-6 border-end border-bottom">
          <a href="salud-mental.php" class="destacado-card d-block text-decoration-none">
            <span class="num">06</span>
            <span class="arrow">&#8599;</span>
            <h3>Salud mental</h3>
            <p>Cuidar la mente es cuidar la vida</p>
          </a>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="row g-0">
      <div class="col-lg-6 bienestar-panel">
        <div class="bienestar-eyebrow">Bienestar cotidiano</div>
        <h2>Cuidarse puede ser más simple.</h2>
        <p>Información útil para incorporar en tu rutina, sin exigencias ni fórmulas mágicas.</p>
      </div>
      <div class="col-lg-6">
        <div class="row g-0 h-100 bienestar-images">
          <div class="col-8">
            <img src="img/bienestar-alimentacion.jpg" alt="Variedad de vegetales y frutas frescas en bandejas">
          </div>
          <div class="col-4 d-flex flex-column">
            <img src="img/bienestar-actividad.jpg" alt="Persona levantando pesas en un gimnasio" class="flex-fill">
            <img src="img/bienestar-mental.jpg" alt="Persona meditando al aire libre al atardecer" class="flex-fill">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="contacto">
    <div class="row g-0">
      <div class="col-lg-4 contacto-panel">
        <div class="contacto-eyebrow">11 — Contacto</div>
        <h2>Hablemos de tu salud.</h2>
        <p>Dejanos tu consulta y te orientamos hacia la sección o fuente de información que necesitás.</p>
        <div class="contacto-hours">
          Lun a vie · 9 a 18 h<br>
          medsalud@info.ar
        </div>
      </div>
      <div class="col-lg-8 contacto-form-panel">
        <form>
          <div class="row g-4">
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" placeholder="Tu nombre" required>
            </div>
            <div class="col-md-6">
              <label for="correo" class="form-label">Correo</label>
              <input type="email" class="form-control" id="correo" placeholder="nombre@email.com" required>
            </div>
            <div class="col-12">
              <label for="mensaje" class="form-label">Mensaje</label>
              <textarea class="form-control" id="mensaje" rows="2" placeholder="¿En qué podemos ayudarte?" required></textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn-medsalud">Enviar consulta</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>