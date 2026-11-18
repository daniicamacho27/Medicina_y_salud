<?php
require_once __DIR__ . '/_guard.php';
// DELETE: solo acepta POST (un enlace GET no debería borrar datos)
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php?status=notfound');
    exit;
}

$stmt = $pdo->prepare("DELETE FROM articulos WHERE id_articulo = :id");
$stmt->execute([':id' => $id]);

header('Location: index.php?status=' . ($stmt->rowCount() > 0 ? 'deleted' : 'notfound'));
exit;
