<?php
// TP N° 9 - Endpoint JSON: busca artículos publicados (búsqueda en vivo).
// GET /api/buscar_articulos.php?q=diabetes&categoria=1
header('Content-Type: application/json; charset=utf-8');

function responder(int $codigo, array $cuerpo): void
{
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    exit;
}

// Solo se permite GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    responder(405, ['status' => 'error', 'message' => 'Método no permitido. Usá GET.']);
}

$q = trim((string) ($_GET['q'] ?? ''));
$categoria = trim((string) ($_GET['categoria'] ?? ''));

// Validación de parámetros -> 400 Bad Request
if (mb_strlen($q) > 100) {
    responder(400, ['status' => 'error', 'message' => 'La búsqueda no puede superar los 100 caracteres.']);
}
if ($categoria !== '' && !ctype_digit($categoria)) {
    responder(400, ['status' => 'error', 'message' => 'La categoría indicada no es válida.']);
}

require_once __DIR__ . '/../config/conexion.php'; // define $pdo

try {
    $sql = "SELECT a.id_articulo AS id, a.titulo, a.resumen, a.fecha_publicacion,
                   c.nombre AS categoria
            FROM articulos a
            INNER JOIN categorias c        ON c.id_categoria = a.id_categoria
            INNER JOIN estados_articulo es ON es.id_estado   = a.id_estado
            WHERE es.nombre = 'publicado'";
    $params = [];

    if ($q !== '') {
        // Se escapan % y _ para que se busquen como texto literal
        $like = '%' . addcslashes(mb_strtolower($q, 'UTF-8'), '%_\\') . '%';
        $sql .= " AND (LOWER(a.titulo) LIKE :q1 OR LOWER(a.resumen) LIKE :q2)";
        $params[':q1'] = $like;
        $params[':q2'] = $like;
    }
    if ($categoria !== '') {
        $sql .= " AND a.id_categoria = :cat";
        $params[':cat'] = (int) $categoria;
    }

    $sql .= " ORDER BY (a.fecha_publicacion IS NULL), a.fecha_publicacion DESC, a.id_articulo DESC LIMIT 20";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $articulos = $stmt->fetchAll();

    // Hay filtros y no hay coincidencias -> 404 Not Found
    if (!$articulos && ($q !== '' || $categoria !== '')) {
        responder(404, ['status' => 'error', 'message' => 'No se encontraron artículos para esa búsqueda.']);
    }

    responder(200, ['status' => 'success', 'total' => count($articulos), 'data' => $articulos]);
} catch (PDOException $e) {
    error_log('API buscar_articulos: ' . $e->getMessage());
    responder(500, ['status' => 'error', 'message' => 'Error al consultar la base de datos.']);
}
