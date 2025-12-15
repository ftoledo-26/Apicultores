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
        $sql = "SELECT id, nombre, email, rol FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute(); 
        return $stmt->fetchAll();
    }

    public function actualizarUsuario(int $id, string $nuevoNombre, string $nuevoEmail): void
    {
        $sql = "UPDATE usuarios SET nombre = :nuevoNombre, email = :nuevoEmail WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nuevoNombre', $nuevoNombre);
        $stmt->bindParam(':nuevoEmail', $nuevoEmail);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
    }
    public function eliminarpersona(int $id)
    {
        $sql = "DELETE FROM  comentarios WHERE id_usuario=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
    }
    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT id, nombre, email, rol FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();
        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }
    public function obtenerPorIdyRelacion(int $id, string $relacion): ?array
    {
        if ($relacion === 'comentarios') {
            $sql = "SELECT usuarios.id, usuarios.nombre, usuarios.email, 
                    comentarios.id as comentario_id, comentarios.comentario 
                    FROM usuarios LEFT JOIN comentarios ON comentarios.id_usuario = usuarios.id 
                    WHERE usuarios.id = :id";
        } else {
            $sql = "SELECT id, nombre, email FROM usuarios WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll();
        return $resultado ?: null;
    }
    public function crearUsuario($input): int {
        $hashed = password_hash($input['contrasenia'], PASSWORD_DEFAULT);
        $rol = $input['rol'] ?? 'user';

        $sql = "INSERT INTO usuarios (nombre, email, contrasenia, rol) VALUES (:nombre, :email, :contrasenia, :rol)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nombre", $input['nombre']);
        $stmt->bindValue(":email", $input['email']);
        $stmt->bindValue(":contrasenia", $hashed);
        $stmt->bindValue(":rol", $rol);

        $stmt->execute();

        return (int) $this->conn->lastInsertId();
    }

    public function ObtenerCampo($campo):array{
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $campo);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetch();
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