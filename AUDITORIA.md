# Auditoría de Accesibilidad y Formateo

## Herramientas utilizadas
- **Prettier** — formateo automático de código (HTML, CSS, JS)
- **Lighthouse** (Chrome DevTools) — auditoría de accesibilidad, prácticas recomendadas y SEO

## Resultado inicial
- Accesibilidad: 85/100
- Prácticas recomendadas: 100/100
- SEO: 91/100

## Fallas detectadas y corregidas

1. **Falta de punto de referencia principal (`<main>`)**
   El contenido no estaba envuelto en una etiqueta semántica `<main>`.
   → Corregido: se agregó `<main>` envolviendo el contenido principal en las 12 páginas.

2. **Falta de metadescripción**
   Las páginas de categoría no tenían `<meta name="description">`.
   → Corregido: se agregó una metadescripción única por página, basada en su subtítulo.

3. **Contraste de color insuficiente**
   El color de acento terracota (`#d9603f`) usado en textos pequeños (etiquetas de sección, link activo del menú) tenía un ratio de contraste de 3.27:1 sobre el fondo crema, por debajo del mínimo de 4.5:1 exigido para texto normal.
   → Corregido: se creó una variante más oscura (`#b34a2a`, ratio 4.74:1) de uso exclusivo para texto, manteniendo el tono original en fondos y elementos decorativos.

4. **Elementos con `tabindex` mayor a 0**
   Detectado en un `div` inyectado por una extensión del navegador (no pertenece al código del sitio). Verificado en ventana de incógnito.

## Puntaje final
- Accesibilidad: 90/100
- Prácticas recomendadas: 100/100
- SEO: 91/100