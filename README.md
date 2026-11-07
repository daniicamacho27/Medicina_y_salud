# Medicina y Salud

## Descripción
Mockup de la aplicación/sitio web "Medicina y Salud", diseñado en Figma. 
El proyecto contempla 12 secciones que representan las distintas pantallas 
y funcionalidades propuestas para ver y saber mas sobre la salud y medicina donde podras ver comidas saludables, bienestar, actividad fisica y muchas cosas mas.
## 🔗 Enlace a Figma
https://www.figma.com/make/e0wqjoBCll3O7KisvRJua5/Dise%C3%B1ar-sitio-web-MedSalud?t=GU9He07pPcHwmVDY-1

## 📸 Capturas de las secciones
Las imágenes de las 12 secciones del mockup se encuentran en la carpeta `capturas/` de este repositorio.

1. Inicio
2. Medicina
3. Emfermedades
4. Sintomas
5. Prevencion
6. Alimentacion saludable
7. Salud mental
8. Actividad fisica
9. Primeros auxilios
10. Medicamentos
11. Consejos
12. Contacto
...
## Instrucciones de instalación y ejecución local

1. Instalar [XAMPP](https://www.apachefriends.org) (o Laragon) e iniciar el servicio Apache.
2. Clonar este repositorio dentro de la carpeta `htdocs` de XAMPP:
```bash
   cd C:\xampp\htdocs
   git clone https://github.com/daniicamacho27/Medicina_y_salud.git medicina-salud
```
3. Copiar `config/env.example.php` como `config/env.php` y completar los valores:
```bash
   cd medicina-salud/config
   copy env.example.php env.php
```
4. Abrir el navegador en: http://localhost/medicina-salud/index.php 


## Evidencia de funcionamiento

### Servidor local ejecutándose
![Captura del sitio corriendo en localhost](img/1.png)

### Estructura modular (SSI)
![Archivo header.php](img/2.png)
![Archivo nav.php](img/3.png)

### Navegación dinámica
![Página Inicio con título y menú activo](img/4.png)
![Página Medicina con título y menú activo](img/5.png)
![Página Enfermedades con título y menú activo](img/6.png)

### Configuración de variables de entorno
![Archivo config/env.example.php](img/8.png)

## Autora

Daniela Luz Belén Camacho

## Autor/es
Daniela Luz Belén Camacho

## Materia / Proyecto
Programacion Web
Medicina y Salud

## Clase 5 — Procesamiento de Formularios y Seguridad Web

Todo el desarrollo de esta entrega está en la carpeta [`clase5/`](clase5/).

### Formulario POST — Contacto (`clase5/contacto.php`)
Recibe `nombre`, `correo` y `mensaje` por **POST**. También se puede enviar desde el formulario de la página de inicio (`index.php`), que apunta a este mismo archivo.

- **Sanitización:** `filter_input(INPUT_POST, ...)` + `trim()`; toda salida se escapa con `e()` (`htmlspecialchars` con `ENT_QUOTES` y `UTF-8`) para evitar XSS.
- **Validación en servidor:** campos obligatorios; nombre de 2 a 60 caracteres; correo con `filter_var(FILTER_VALIDATE_EMAIL)`; mensaje de al menos 10 caracteres.
- **Mensajes:** alerta verde si el envío es correcto; alerta roja con la lista de errores y mensaje debajo de cada campo (`is-invalid` de Bootstrap).
- **Persistencia:** si hay errores, los campos conservan lo que se escribió.

### Formulario GET — Buscador (`clase5/buscar.php`)
Recibe el parámetro `q` por **GET** (ej: `buscar.php?q=salud`) y busca en las secciones del sitio con `mb_stripos`.

- **Sanitización:** `filter_input(INPUT_GET, ...)` + `trim()` y escape con `e()`.
- **Validación:** término no vacío y de al menos 2 caracteres.
- **Mensajes:** resultados encontrados, "sin resultados" o error de validación. El término se conserva en el campo.

### Archivos
| Archivo | Función |
|---|---|
| `clase5/funciones.php` | Función `e()` para escapar la salida |
| `clase5/contacto.php` | Formulario POST |
| `clase5/buscar.php` | Formulario GET |

### Capturas

**Contacto**
![Contacto vacío](clase5/capturas/contacto.php)


**Búsqueda**
![Búsqueda vacía](clase5/capturas/buscar.php)


