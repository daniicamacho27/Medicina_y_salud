<?php
// Guarda las sesiones de PHP en la tabla `sessions` (ver postgres/schema.sql).
class SesionPostgres implements SessionHandlerInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function open(string $path, string $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read(string $id): string|false
    {
        try {
            $stmt = $this->pdo->prepare('SELECT data FROM sessions WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetchColumn();
            return $data === false ? '' : (string) base64_decode($data);
        } catch (PDOException $e) { // p. ej. todavía no se creó la tabla
            error_log('Sesión (read): ' . $e->getMessage());
            return '';
        }
    }

    public function write(string $id, string $data): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO sessions (id, data, updated_at) VALUES (:id, :data, :t)
                 ON CONFLICT (id) DO UPDATE SET data = EXCLUDED.data, updated_at = EXCLUDED.updated_at'
            );
            return $stmt->execute([':id' => $id, ':data' => base64_encode($data), ':t' => time()]);
        } catch (PDOException $e) {
            error_log('Sesión (write): ' . $e->getMessage());
            return false;
        }
    }

    public function destroy(string $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM sessions WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function gc(int $max_lifetime): int|false
    {
        $stmt = $this->pdo->prepare('DELETE FROM sessions WHERE updated_at < :limite');
        $stmt->execute([':limite' => time() - $max_lifetime]);
        return $stmt->rowCount();
    }
}
