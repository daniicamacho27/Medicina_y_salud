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
