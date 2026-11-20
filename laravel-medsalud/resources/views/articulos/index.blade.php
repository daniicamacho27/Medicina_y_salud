<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Artículos publicados · MedSalud (Laravel)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container my-5">
  <h1 class="mb-1">Artículos publicados</h1>
  <p class="text-muted">Módulo implementado con Laravel (ruta, controlador, modelo Eloquent y vista Blade).</p>

  @forelse ($articulos as $articulo)
    <article class="card mb-3 p-3">
      <span class="badge text-bg-secondary mb-2 align-self-start">{{ $articulo->categoria->nombre }}</span>
      <h2 class="h5">{{ $articulo->titulo }}</h2>
      <p class="mb-2">{{ $articulo->resumen ?? 'Sin resumen disponible.' }}</p>
      <small class="text-muted">
        Estado: {{ $articulo->estado->nombre }}
        @if ($articulo->fecha_publicacion)
          · Publicado: {{ $articulo->fecha_publicacion->format('d/m/Y') }}
        @endif
      </small>
    </article>
  @empty
    <div class="alert alert-warning">No hay artículos publicados.</div>
  @endforelse
</main>
</body>
</html>
