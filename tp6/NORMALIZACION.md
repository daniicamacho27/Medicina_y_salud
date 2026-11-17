# TP N° 6 – Normalización y esquema relacional (MedSalud)

**Proyecto:** Medicina y Salud (MedSalud) · **Materia:** Programación Web · **Docente:** Lic. Gabriel Artaza
**Autora:** Daniela Luz Belén Camacho

## Parte 1 – Normalización aplicada al proyecto

### 1. Tabla principal sin normalizar

El sitio publica artículos de salud (enfermedades, alimentación, actividad física, etc.).
Si se guardara todo en una sola tabla, un registro se vería así:

| id_articulo | titulo | autor_nombre | autor_email | rol_autor | rol_descripcion | categoria | categoria_descripcion | estado | etiquetas |
|---|---|---|---|---|---|---|---|---|---|
| 1 | Diabetes tipo 2: qué es y cómo prevenirla | Daniela Camacho | daniela@medsalud.com | admin | Administra usuarios y contenido | Enfermedades | Información sobre enfermedades frecuentes | publicado | prevencion, diabetes |
| 2 | 5 desayunos saludables | Lucía Gómez | lucia@medsalud.com | editor | Crea y edita artículos | Alimentación saludable | Hábitos y recetas para comer mejor | borrador | nutricion |
| 3 | Rutina de caminata | Lucía Gómez | lucia@medsalud.com | editor | Crea y edita artículos | Actividad física | Ejercicio y vida activa | publicado | prevencion, ejercicio, nutricion |

Problemas que se observan:

- **Campo multivalorado:** `etiquetas` guarda varios valores separados por coma.
- **Redundancia:** los datos de Lucía y de su rol se repiten en cada artículo que escribe; la descripción de la categoría se repite en cada artículo de esa categoría.
- **Anomalías:** si cambia el email de Lucía hay que modificarlo en muchas filas (actualización); si se borra el único artículo de una categoría se pierde la categoría (eliminación).


### 2. Proceso de normalización

#### Primera Forma Normal (1FN)

Se elimina el grupo repetitivo `etiquetas`: cada celda debe tener un único valor (atómico).
Pasa a haber **una fila por cada par artículo–etiqueta**, y la clave primaria pasa a ser compuesta `(id_articulo, etiqueta)`.

| **id_articulo** | titulo | autor_nombre | autor_email | rol_autor | rol_descripcion | categoria | categoria_descripcion | estado | **etiqueta** |
|---|---|---|---|---|---|---|---|---|---|
| 1 | Diabetes tipo 2... | Daniela Camacho | daniela@medsalud.com | admin | Administra usuarios... | Enfermedades | Información sobre... | publicado | prevencion |
| 1 | Diabetes tipo 2... | Daniela Camacho | daniela@medsalud.com | admin | Administra usuarios... | Enfermedades | Información sobre... | publicado | diabetes |
| 2 | 5 desayunos saludables | Lucía Gómez | lucia@medsalud.com | editor | Crea y edita... | Alimentación saludable | Hábitos y recetas... | borrador | nutricion |

#### Segunda Forma Normal (2FN)

Con la clave compuesta `(id_articulo, etiqueta)`, todos los atributos excepto `etiqueta` dependen **solo de `id_articulo`** (dependencia parcial). Se descompone:

- **articulos** `(id_articulo, titulo, autor_nombre, autor_email, rol_autor, rol_descripcion, categoria, categoria_descripcion, estado)` → PK `id_articulo`
- **articulo_etiqueta** `(id_articulo, etiqueta)` → PK compuesta `(id_articulo, etiqueta)`

#### Tercera Forma Normal (3FN)

Quedan **dependencias transitivas** (un atributo no-clave depende de otro no-clave):

- `autor_nombre`, `autor_email`, `rol_autor` dependen del **usuario**, no del artículo → tabla `usuarios`.
- `rol_descripcion` depende de `rol_autor` → tabla `roles`.
- `categoria_descripcion` depende de `categoria` → tabla `categorias`.
- `estado` es un valor de un conjunto fijo (borrador / publicado / archivado) → tabla `estados_articulo`.
- `etiqueta` se repite como texto → tabla `etiquetas`, y `articulo_etiqueta` pasa a guardar solo las claves foráneas.

Además se agrega la tabla `consultas` para el formulario de contacto del sitio (sección 12 del mockup).
