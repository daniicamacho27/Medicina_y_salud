// TP N° 9 - Búsqueda en vivo con Fetch API (sin recargar la página)
document.addEventListener('DOMContentLoaded', () => {
  const inputBusqueda = document.getElementById('inputBusqueda');
  const selectCategoria = document.getElementById('selectCategoria');
  const contenedor = document.getElementById('resultados');
  const estado = document.getElementById('estadoBusqueda');

  if (!inputBusqueda || !contenedor) return;

  let temporizador = null;
  let controlador = null; // permite cancelar la petición anterior

  // Escapa HTML para evitar XSS al insertar datos de la BD en el DOM
  function esc(texto) {
    const div = document.createElement('div');
    div.textContent = texto ?? '';
    return div.innerHTML;
  }

  function mostrarMensaje(clase, texto) {
    contenedor.innerHTML = `<div class="alert alert-${clase}" role="alert">${esc(texto)}</div>`;
  }

  function renderizarResultados(articulos) {
    contenedor.innerHTML = '';
    articulos.forEach((a) => {
      const col = document.createElement('div');
      col.className = 'col-md-6';
      col.innerHTML = `
        <article class="card h-100 p-3">
          <span class="badge text-bg-secondary mb-2 align-self-start">${esc(a.categoria)}</span>
          <h2 class="h5">${esc(a.titulo)}</h2>
          <p class="mb-2">${esc(a.resumen || 'Sin resumen disponible.')}</p>
          <small class="text-muted">${a.fecha_publicacion ? 'Publicado: ' + esc(a.fecha_publicacion) : ''}</small>
        </article>`;
      contenedor.appendChild(col);
    });
  }

  async function buscar() {
    const q = inputBusqueda.value.trim();
    const categoria = selectCategoria ? selectCategoria.value : '';

    // Cancela la petición anterior si todavía está en curso
    if (controlador) controlador.abort();
    controlador = new AbortController();

    const params = new URLSearchParams();
    if (q) params.set('q', q);
    if (categoria) params.set('categoria', categoria);

    estado.textContent = 'Buscando...';

    try {
      const response = await fetch(`api/buscar_articulos.php?${params.toString()}`, {
        signal: controlador.signal,
        headers: { Accept: 'application/json' },
      });
      const res = await response.json();

      if (response.status === 404) {
        mostrarMensaje('warning', res.message);
        estado.textContent = '0 resultados';
        return;
      }
      if (!response.ok) {
        throw new Error(res.message || `Error HTTP: ${response.status}`);
      }

      renderizarResultados(res.data);
      estado.textContent = `${res.total} resultado(s)`;
    } catch (error) {
      if (error.name === 'AbortError') return; // búsqueda reemplazada por otra más nueva
      console.error('Error al realizar la petición:', error);
      mostrarMensaje('danger', 'No se pudo completar la búsqueda. Intentá de nuevo.');
      estado.textContent = '';
    }
  }

  // Debounce: espera 300 ms sin tipear antes de consultar
  inputBusqueda.addEventListener('input', () => {
    clearTimeout(temporizador);
    temporizador = setTimeout(buscar, 300);
  });

  if (selectCategoria) selectCategoria.addEventListener('change', buscar);

  buscar(); // carga inicial
});
