-- =====================================================================
-- TP N° 6 - Programación Web
-- Proyecto: Medicina y Salud (MedSalud)
-- Script DDL: creación del esquema relacional en MySQL
-- Autora: Daniela Luz Belén Camacho
-- =====================================================================

CREATE DATABASE IF NOT EXISTS medsalud
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE medsalud;

-- ---------------------------------------------------------------------
-- 1) TABLAS MAESTRAS / SECUNDARIAS
-- ---------------------------------------------------------------------

-- Roles de usuario (admin, editor, lector)
CREATE TABLE IF NOT EXISTS roles (
  id_rol      INT AUTO_INCREMENT PRIMARY KEY,
  nombre      VARCHAR(30)  NOT NULL UNIQUE,
  descripcion VARCHAR(150) NULL
) ENGINE=InnoDB;

-- Categorías = secciones del sitio (Medicina, Enfermedades, Síntomas, ...)
CREATE TABLE IF NOT EXISTS categorias (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre       VARCHAR(60)  NOT NULL UNIQUE,
  slug         VARCHAR(80)  NOT NULL UNIQUE,
  descripcion  VARCHAR(255) NULL
) ENGINE=InnoDB;

-- Estados de un artículo (borrador, publicado, archivado)
CREATE TABLE IF NOT EXISTS estados_articulo (
  id_estado INT AUTO_INCREMENT PRIMARY KEY,
  nombre    VARCHAR(30) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Etiquetas (palabras clave que se reutilizan entre artículos)
CREATE TABLE IF NOT EXISTS etiquetas (
  id_etiqueta INT AUTO_INCREMENT PRIMARY KEY,
  nombre      VARCHAR(40) NOT NULL UNIQUE
) ENGINE=InnoDB;


-- ---------------------------------------------------------------------
-- 2) USUARIOS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  id_rol     INT          NOT NULL,
  nombre     VARCHAR(60)  NOT NULL,
  apellido   VARCHAR(60)  NOT NULL,
  email      VARCHAR(120) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL COMMENT 'Hash generado con password_hash()',
  telefono   VARCHAR(25)  NULL,
  activo     TINYINT(1)   NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_usuarios_rol
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 3) TABLA PRINCIPAL DE NEGOCIO: ARTÍCULOS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS articulos (
  id_articulo       INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario        INT          NOT NULL COMMENT 'Autor',
  id_categoria      INT          NOT NULL,
  id_estado         INT          NOT NULL,
  titulo            VARCHAR(150) NOT NULL,
  resumen           VARCHAR(255) NULL,
  contenido         TEXT         NOT NULL,
  imagen            VARCHAR(255) NULL,
  fecha_publicacion DATE         NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_articulos_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_articulos_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_articulos_estado
    FOREIGN KEY (id_estado) REFERENCES estados_articulo(id_estado)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 4) TABLA DE RELACIÓN N:M (artículos <-> etiquetas)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS articulo_etiqueta (
  id_articulo INT NOT NULL,
  id_etiqueta INT NOT NULL,
  PRIMARY KEY (id_articulo, id_etiqueta),
  CONSTRAINT fk_ae_articulo
    FOREIGN KEY (id_articulo) REFERENCES articulos(id_articulo)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_ae_etiqueta
    FOREIGN KEY (id_etiqueta) REFERENCES etiquetas(id_etiqueta)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 5) CONSULTAS (formulario de contacto del sitio)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS consultas (
  id_consulta INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario  INT          NULL COMMENT 'NULL si la consulta es de un visitante',
  nombre      VARCHAR(80)  NOT NULL,
  email       VARCHAR(120) NOT NULL,
  asunto      VARCHAR(120) NOT NULL,
  mensaje     TEXT         NOT NULL,
  leida       TINYINT(1)   NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_consultas_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;
