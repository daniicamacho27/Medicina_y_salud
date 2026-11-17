-- =====================================================================
-- TP N° 6 - Consultas de prueba CRUD (Proyecto MedSalud)
-- Ejecutar DESPUÉS de schema.sql
-- =====================================================================
USE medsalud;

-- =====================================================================
-- CREATE
-- =====================================================================

-- Tablas maestras
INSERT INTO roles (nombre, descripcion) VALUES
  ('admin',  'Administra usuarios y contenido'),
  ('editor', 'Crea y edita artículos');

INSERT INTO categorias (nombre, slug, descripcion) VALUES
  ('Enfermedades',          'enfermedades',          'Información sobre enfermedades frecuentes'),
  ('Alimentación saludable','alimentacion-saludable','Hábitos y recetas para comer mejor'),
  ('Actividad física',      'actividad-fisica',      'Ejercicio y vida activa');

INSERT INTO estados_articulo (nombre) VALUES
  ('borrador'), ('publicado'), ('archivado');

INSERT INTO etiquetas (nombre) VALUES
  ('prevencion'), ('nutricion'), ('diabetes');

-- Usuarios (passwords hasheadas con password_hash / bcrypt)
INSERT INTO usuarios (id_rol, nombre, apellido, email, password, telefono) VALUES
  (1, 'Daniela', 'Camacho', 'daniela@medsalud.com',
   '$2y$10$aQM/T6tLMdye9aSOWRTkzeH0louIpaFL0PK9XaffptJ6.bECA283G', '387-5551234'),
  (2, 'Lucía',   'Gómez',   'lucia@medsalud.com',
   '$2y$10$RTKBCNji7HKFdOKdrGKkS.o1ToSvqJqfNiDJOHTfm0Zcw1sNp8v3m', NULL);

-- Tabla principal (vinculando FK: autor, categoría y estado)
INSERT INTO articulos
  (id_usuario, id_categoria, id_estado, titulo, resumen, contenido, fecha_publicacion)
VALUES
  (1, 1, 2, 'Diabetes tipo 2: qué es y cómo prevenirla',
   'Conceptos básicos sobre la diabetes tipo 2.',
   'La diabetes tipo 2 aparece cuando el cuerpo no usa bien la insulina...', '2026-11-10'),
  (2, 2, 1, '5 desayunos saludables',
   'Ideas simples para empezar el día.',
   'Avena con frutas, yogur natural con semillas, tostadas integrales...', NULL);

-- Relación N:M (etiquetas de cada artículo)
INSERT INTO articulo_etiqueta (id_articulo, id_etiqueta) VALUES
  (1, 1), (1, 3), (2, 2);

-- Consulta enviada desde el formulario de contacto
INSERT INTO consultas (id_usuario, nombre, email, asunto, mensaje) VALUES
  (NULL, 'Carlos Pérez', 'carlos@correo.com', 'Duda sobre alimentación',
   'Hola, ¿tienen información sobre dietas para hipertensos?');


-- =====================================================================
-- READ
-- =====================================================================

-- SELECT con WHERE + ORDER BY: artículos publicados, del más nuevo al más viejo
SELECT id_articulo, titulo, fecha_publicacion
FROM articulos
WHERE id_estado = 2
ORDER BY fecha_publicacion DESC;

-- INNER JOIN: artículo + autor + categoría + estado
SELECT a.titulo,
       CONCAT(u.nombre, ' ', u.apellido) AS autor,
       c.nombre AS categoria,
       e.nombre AS estado
FROM articulos a
INNER JOIN usuarios u         ON u.id_usuario   = a.id_usuario
INNER JOIN categorias c       ON c.id_categoria = a.id_categoria
INNER JOIN estados_articulo e ON e.id_estado    = a.id_estado
ORDER BY a.titulo;

-- INNER JOIN N:M: etiquetas de cada artículo
SELECT a.titulo, t.nombre AS etiqueta
FROM articulos a
INNER JOIN articulo_etiqueta ae ON ae.id_articulo = a.id_articulo
INNER JOIN etiquetas t          ON t.id_etiqueta  = ae.id_etiqueta
ORDER BY a.titulo, t.nombre;


-- =====================================================================
-- UPDATE
-- =====================================================================

-- Publicar el borrador (cambia el estado y la fecha del artículo 2)
UPDATE articulos
SET id_estado = 2,
    fecha_publicacion = '2026-11-17'
WHERE id_articulo = 2;

-- =====================================================================
-- DELETE
-- =====================================================================

-- Dar de baja la consulta de prueba
DELETE FROM consultas
WHERE id_consulta = 1;
