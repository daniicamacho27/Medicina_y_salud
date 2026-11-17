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
