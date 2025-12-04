<?php
class UsuariosModels {
    private PDO $conn;

    public function __construct(PDO $pdo){
        $this->conn = $pdo;
    }

    public function añadir(string $usuario, string $email, string $passw) :void{
        $sql = "INSERT INTO ususario(usuario, email, password) VALUES (:usuario, :email , :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $passw); 

        $stmt->execute();
    }
     public function obtenerTodos(): array
    {
        $sql = "SELECT id, nombre, email FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute(); 
        return $stmt->fetchAll();
    }

    public function actualizarUser(int $id, string $nuevoNombre, string $nuevoEmail): void
    {
        $sql = "UPDATE usuarios SET nombre = :nuevoNombre, email = :nuevoEmail WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nuevoNombre', $nuevoNombre);
        $stmt->bindParam(':nuevoEmail', $nuevoEmail);
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
    }
    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT id, nombre, email FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();
        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }
        public function eliminarpersona(string $nombre ,int $id): array
    {
        $sql = "DELETE FROM  usuario WHERE nombre=:nombre AND id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);
        $stmt->execute(); // No hay parámetros, pero igual se ejecuta
        return $stmt->fetchAll();
    }



    public function obtenerUsuariosPaginados(int $limit, int $page): array
    {
        $page = ($page - 1) * $limit;
        $sql = "SELECT id, nombre, email FROM usuarios LIMIT :limit OFFSET :page";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':page', $page, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    
}

?>