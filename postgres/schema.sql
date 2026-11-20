-- =====================================================================
-- MedSalud · Esquema + datos iniciales para POSTGRES (Neon en Vercel)
-- Pegar COMPLETO en: Vercel → Storage → tu base Neon → Query / SQL Editor.
-- Ejecutar una sola vez sobre una base vacía.
-- =====================================================================

CREATE TABLE roles (
  id_rol      SERIAL PRIMARY KEY,
  nombre      VARCHAR(30)  NOT NULL UNIQUE,
  descripcion VARCHAR(150)
);

CREATE TABLE categorias (
  id_categoria SERIAL PRIMARY KEY,
  nombre       VARCHAR(60)  NOT NULL UNIQUE,
  slug         VARCHAR(80)  NOT NULL UNIQUE,
  descripcion  VARCHAR(255)
);

CREATE TABLE estados_articulo (
  id_estado SERIAL PRIMARY KEY,
  nombre    VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE etiquetas (
  id_etiqueta SERIAL PRIMARY KEY,
  nombre      VARCHAR(40) NOT NULL UNIQUE
);

CREATE TABLE usuarios (
  id_usuario SERIAL PRIMARY KEY,
  id_rol     INT          NOT NULL,
  nombre     VARCHAR(60)  NOT NULL,
  apellido   VARCHAR(60)  NOT NULL,
  email      VARCHAR(120) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  telefono   VARCHAR(25),
  activo     SMALLINT     NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_usuarios_rol
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
    ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE articulos (
  id_articulo       SERIAL PRIMARY KEY,
  id_usuario        INT          NOT NULL,
  id_categoria      INT          NOT NULL,
  id_estado         INT          NOT NULL,
  titulo            VARCHAR(150) NOT NULL,
  resumen           VARCHAR(255),
  contenido         TEXT         NOT NULL,
  imagen            VARCHAR(255),
  fecha_publicacion DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_articulos_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_articulos_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_articulos_estado
    FOREIGN KEY (id_estado) REFERENCES estados_articulo(id_estado)
    ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE articulo_etiqueta (
  id_articulo INT NOT NULL,
  id_etiqueta INT NOT NULL,
  PRIMARY KEY (id_articulo, id_etiqueta),
  CONSTRAINT fk_ae_articulo
    FOREIGN KEY (id_articulo) REFERENCES articulos(id_articulo)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_ae_etiqueta
    FOREIGN KEY (id_etiqueta) REFERENCES etiquetas(id_etiqueta)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE consultas (
  id_consulta SERIAL PRIMARY KEY,
  id_usuario  INT,
  nombre      VARCHAR(80)  NOT NULL,
  email       VARCHAR(120) NOT NULL,
  asunto      VARCHAR(120) NOT NULL,
  mensaje     TEXT         NOT NULL,
  leida       SMALLINT     NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_consultas_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE SET NULL
);

-- Sesiones de PHP (en Vercel no hay disco compartido entre ejecuciones)
CREATE TABLE sessions (
  id         VARCHAR(128) PRIMARY KEY,
  data       TEXT   NOT NULL,
  updated_at BIGINT NOT NULL
);
CREATE INDEX idx_sessions_updated_at ON sessions (updated_at);

CREATE INDEX idx_articulos_categoria_estado ON articulos (id_categoria, id_estado);
CREATE INDEX idx_consultas_leida_fecha ON consultas (leida, created_at);

-- =====================================================================
-- DATOS INICIALES
-- =====================================================================
INSERT INTO roles (nombre, descripcion) VALUES
  ('admin',   'Administra usuarios y contenido'),
  ('editor',  'Crea y edita artículos'),
  ('usuario', 'Usuario registrado sin permisos de administración');

INSERT INTO categorias (nombre, slug, descripcion) VALUES
  ('Enfermedades',          'enfermedades',          'Información sobre enfermedades frecuentes'),
  ('Alimentación saludable','alimentacion-saludable','Hábitos y recetas para comer mejor'),
  ('Actividad física',      'actividad-fisica',      'Ejercicio y vida activa');

INSERT INTO estados_articulo (nombre) VALUES
  ('borrador'), ('publicado'), ('archivado');

INSERT INTO etiquetas (nombre) VALUES
  ('prevencion'), ('nutricion'), ('diabetes');

INSERT INTO usuarios (id_rol, nombre, apellido, email, password, telefono) VALUES
  (1, 'Daniela', 'Camacho', 'daniela@medsalud.com',
   '$2y$10$aQM/T6tLMdye9aSOWRTkzeH0louIpaFL0PK9XaffptJ6.bECA283G', '387-5551234'),
  (2, 'Lucía',   'Gómez',   'lucia@medsalud.com',
   '$2y$10$RTKBCNji7HKFdOKdrGKkS.o1ToSvqJqfNiDJOHTfm0Zcw1sNp8v3m', NULL);

INSERT INTO articulos (id_usuario, id_categoria, id_estado, titulo, resumen, contenido, fecha_publicacion) VALUES
  (1, 1, 2, 'Diabetes tipo 2: qué es y cómo prevenirla',
   'Conceptos básicos sobre la diabetes tipo 2.',
   'La diabetes tipo 2 aparece cuando el cuerpo no usa bien la insulina...', '2026-11-10'),
  (2, 2, 2, '5 desayunos saludables',
   'Ideas simples para empezar el día.',
   'Avena con frutas, yogur natural con semillas, tostadas integrales...', '2026-11-17'),
  (1, 1, 2, 'Hipertensión: cómo controlarla', 'Claves para medir y mantener la presión arterial.', 'La hipertensión suele ser silenciosa...', '2026-11-12'),
  (1, 2, 2, 'Desayunos saludables para toda la semana', 'Ideas simples con avena, frutas y yogur.', 'Avena con frutas, yogur natural...', '2026-11-13'),
  (2, 3, 2, 'Caminar 30 minutos al día', 'Beneficios de la actividad física moderada.', 'Caminar mejora la salud cardiovascular...', '2026-11-14'),
  (2, 2, 2, 'Cuánta agua tomar por día', 'Hidratación y salud: mitos y verdades.', 'La hidratación adecuada depende de...', '2026-11-15'),
  (1, 1, 2, 'Prevención de la gripe en invierno', 'Vacunación y hábitos para evitar contagios.', 'La vacuna antigripal es la mejor herramienta...', '2026-11-16');

INSERT INTO articulo_etiqueta (id_articulo, id_etiqueta) VALUES
  (1, 1), (1, 3), (2, 2);

-- =====================================================================
-- OPCIONAL (al final a propósito): equivalente de "ON UPDATE CURRENT_TIMESTAMP".
-- Si el editor SQL se queja por el bloque $$, podés omitirlo: la app funciona igual.
-- =====================================================================
CREATE FUNCTION set_updated_at() RETURNS trigger AS $$
BEGIN
  NEW.updated_at = CURRENT_TIMESTAMP;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_usuarios_updated  BEFORE UPDATE ON usuarios  FOR EACH ROW EXECUTE FUNCTION set_updated_at();
CREATE TRIGGER trg_articulos_updated BEFORE UPDATE ON articulos FOR EACH ROW EXECUTE FUNCTION set_updated_at();
CREATE TRIGGER trg_consultas_updated BEFORE UPDATE ON consultas FOR EACH ROW EXECUTE FUNCTION set_updated_at();
