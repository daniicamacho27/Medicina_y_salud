<?php
// MODELO: único lugar donde viven las consultas SQL de artículos (PDO + prepared statements).
class ArticuloModel
{
    public function __construct(private PDO $pdo)
    {
    }

    /** Listado con INNER JOIN. */
    public function listar(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT a.id_articulo, a.titulo, a.fecha_publicacion,
                    CONCAT(u.nombre, ' ', u.apellido) AS autor,
                    c.nombre AS categoria,
                    es.nombre AS estado
             FROM articulos a
             INNER JOIN usuarios u          ON u.id_usuario   = a.id_usuario
             INNER JOIN categorias c        ON c.id_categoria = a.id_categoria
             INNER JOIN estados_articulo es ON es.id_estado   = a.id_estado
             ORDER BY a.id_articulo DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscar(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articulos WHERE id_articulo = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch();
        return $fila ?: null;
    }

    public function crear(array $d): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO articulos
                (id_usuario, id_categoria, id_estado, titulo, resumen, contenido, fecha_publicacion)
             VALUES
                (:id_usuario, :id_categoria, :id_estado, :titulo, :resumen, :contenido, :fecha)"
        );
        $stmt->execute($this->parametros($d));
    }

    public function actualizar(int $id, array $d): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE articulos
             SET id_usuario = :id_usuario, id_categoria = :id_categoria, id_estado = :id_estado,
                 titulo = :titulo, resumen = :resumen, contenido = :contenido,
                 fecha_publicacion = :fecha
             WHERE id_articulo = :id"
        );
        $stmt->execute($this->parametros($d) + [':id' => $id]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM articulos WHERE id_articulo = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /** Listas para los <select> del formulario (claves foráneas). */
    public function listas(): array
    {
        return [
            'usuarios'   => $this->pdo->query("SELECT id_usuario AS id, CONCAT(nombre, ' ', apellido) AS nombre
                                               FROM usuarios WHERE activo = 1 ORDER BY apellido, nombre")->fetchAll(),
            'categorias' => $this->pdo->query("SELECT id_categoria AS id, nombre FROM categorias ORDER BY nombre")->fetchAll(),
            'estados'    => $this->pdo->query("SELECT id_estado AS id, nombre FROM estados_articulo ORDER BY id_estado")->fetchAll(),
        ];
    }

    private function parametros(array $d): array
    {
        return [
            ':id_usuario'   => $d['id_usuario'],
            ':id_categoria' => $d['id_categoria'],
            ':id_estado'    => $d['id_estado'],
            ':titulo'       => $d['titulo'],
            ':resumen'      => $d['resumen'] !== '' ? $d['resumen'] : null,
            ':contenido'    => $d['contenido'],
            ':fecha'        => $d['fecha_publicacion'] !== '' ? $d['fecha_publicacion'] : null,
        ];
    }
}
