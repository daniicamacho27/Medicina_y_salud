<?php
// Funciones de presentación para los <select> y los errores del formulario.
function opciones(array $lista, string $seleccionado): void
{
    foreach ($lista as $o) {
        $sel = ((string) $o['id'] === $seleccionado) ? ' selected' : '';
        echo '<option value="' . e($o['id']) . '"' . $sel . '>' . e($o['nombre']) . '</option>';
    }
}

function clase_error(array $errores, string $campo): string
{
    return isset($errores[$campo]) ? ' is-invalid' : '';
}
