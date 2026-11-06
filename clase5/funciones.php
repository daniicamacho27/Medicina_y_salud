<?php
// Escapa cualquier dato antes de mostrarlo en pantalla (prevención de XSS)
function e(?string $valor): string {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
