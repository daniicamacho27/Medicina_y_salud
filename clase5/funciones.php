<?php
/**
 * Clase 5 - Funciones auxiliares.
 * e(): escapa TODA salida HTML para prevenir XSS.
 */
function e($valor): string
{
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES, 'UTF-8');
}
