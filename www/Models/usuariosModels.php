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
}

?>