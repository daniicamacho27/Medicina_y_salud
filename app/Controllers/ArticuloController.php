<?php
// CONTROLADOR: recibe la solicitud, valida, llama al Modelo y elige la Vista.
// No contiene SQL ni HTML.
class ArticuloController
{
    public function __construct(private ArticuloModel $modelo)
    {
    }

    public function listar(): void
    {
        $mensajes = [
            'created'  => ['success', 'Artículo creado correctamente.'],
            'updated'  => ['success', 'Artículo actualizado correctamente.'],
            'deleted'  => ['success', 'Artículo eliminado correctamente.'],
            'notfound' => ['warning', 'El artículo solicitado no existe.'],
        ];

        $this->render('listado', [
            'titulo_pagina'      => 'Administración',
            'descripcion_pagina' => 'Gestión de artículos de MedSalud.',
            'registros'          => $this->modelo->listar(),
            'mensajes'           => $mensajes,
            'status'             => $_GET['status'] ?? '',
        ]);
    }

    public function crear(): void
    {
        $listas  = $this->modelo->listas();
        $errores = [];
        $datos   = $this->datosVacios();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos   = $this->leerFormulario();
            $errores = $this->validar($datos, $listas);

            if (empty($errores)) {
                $this->modelo->crear($datos);
                $this->redirigir('created');
            }
        }

        $this->render('formulario', [
            'titulo_pagina'      => 'Nuevo artículo',
            'descripcion_pagina' => 'Agregar un artículo a MedSalud.',
            'encabezado'         => 'Nuevo artículo',
            'texto_boton'        => 'Guardar artículo',
            'datos'              => $datos,
            'errores'            => $errores,
            'listas'             => $listas,
        ]);
    }

    public function editar(): void
    {
        $id = filter_var($_POST['id'] ?? $_GET['id'] ?? null, FILTER_VALIDATE_INT);
        $articulo = $id ? $this->modelo->buscar($id) : null;
        if (!$articulo) {
            $this->redirigir('notfound');
        }

        $listas  = $this->modelo->listas();
        $errores = [];
        $datos   = [
            'id_articulo'       => $articulo['id_articulo'],
            'titulo'            => $articulo['titulo'],
            'resumen'           => $articulo['resumen'] ?? '',
            'contenido'         => $articulo['contenido'],
            'id_usuario'        => $articulo['id_usuario'],
            'id_categoria'      => $articulo['id_categoria'],
            'id_estado'         => $articulo['id_estado'],
            'fecha_publicacion' => $articulo['fecha_publicacion'] ?? '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos   = $this->leerFormulario() + ['id_articulo' => $id];
            $errores = $this->validar($datos, $listas);

            if (empty($errores)) {
                $this->modelo->actualizar($id, $datos);
                $this->redirigir('updated');
            }
        }

        $this->render('formulario', [
            'titulo_pagina'      => 'Editar artículo',
            'descripcion_pagina' => 'Modificar un artículo de MedSalud.',
            'encabezado'         => 'Editar artículo #' . $id,
            'texto_boton'        => 'Guardar cambios',
            'datos'              => $datos,
            'errores'            => $errores,
            'listas'             => $listas,
        ]);
    }

    /** Solo acepta POST: un enlace GET no debería borrar datos. */
    public function eliminar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir();
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->redirigir('notfound');
        }

        $this->redirigir($this->modelo->eliminar($id) ? 'deleted' : 'notfound');
    }

    // ---------------------------------------------------------------- helpers

    private function render(string $vista, array $datos): void
    {
        extract($datos);
        $ruta_base = '';
        require __DIR__ . '/../Views/articulos/' . $vista . '.php';
    }

    private function redirigir(string $status = ''): never
    {
        $url = 'articulos.php?accion=listar' . ($status !== '' ? '&status=' . $status : '');
        header('Location: ' . $url);
        exit;
    }

    private function datosVacios(): array
    {
        return ['titulo' => '', 'resumen' => '', 'contenido' => '', 'id_usuario' => '',
                'id_categoria' => '', 'id_estado' => '', 'fecha_publicacion' => ''];
    }

    private function leerFormulario(): array
    {
        $d = [];
        foreach (array_keys($this->datosVacios()) as $campo) {
            $d[$campo] = trim((string) ($_POST[$campo] ?? ''));
        }
        return $d;
    }

    /** Validación en el servidor. Devuelve un array de errores (vacío = todo bien). */
    private function validar(array $d, array $listas): array
    {
        $err = [];

        if ($d['titulo'] === '') {
            $err['titulo'] = 'El título es obligatorio.';
        } elseif (mb_strlen($d['titulo']) < 5 || mb_strlen($d['titulo']) > 150) {
            $err['titulo'] = 'El título debe tener entre 5 y 150 caracteres.';
        }

        if (mb_strlen($d['resumen']) > 255) {
            $err['resumen'] = 'El resumen no puede superar los 255 caracteres.';
        }

        if ($d['contenido'] === '') {
            $err['contenido'] = 'El contenido es obligatorio.';
        }

        foreach (['id_usuario' => 'usuarios', 'id_categoria' => 'categorias', 'id_estado' => 'estados'] as $campo => $lista) {
            $validos = array_map('strval', array_column($listas[$lista], 'id'));
            if (!in_array($d[$campo], $validos, true)) {
                $err[$campo] = 'Elegí una opción válida.';
            }
        }

        if ($d['fecha_publicacion'] !== '') {
            $f = DateTime::createFromFormat('Y-m-d', $d['fecha_publicacion']);
            if (!$f || $f->format('Y-m-d') !== $d['fecha_publicacion']) {
                $err['fecha_publicacion'] = 'La fecha no es válida.';
            }
        }

        return $err;
    }
}
