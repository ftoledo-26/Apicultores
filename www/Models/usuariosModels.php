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

    public function actualizarUser(string $nombreActual, string $nuevoNombre, string $nuevoEmail, int $id): void
    {
        $sql = "UPDATE usuarios SET nombre = :nuevoNombre, email = :nuevoEmail WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nuevoNombre', $nuevoNombre);
        $stmt->bindParam(':nuevoEmail', $nuevoEmail);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function eliminarpersona(int $id)
    {
        $sql = "DELETE FROM  comentarios WHERE id_usuario=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $sql = "DELETE FROM usuarios WHERE id = :id2";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id2", $id, PDO::PARAM_INT);
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
    public function crearUsuario($input):int{
        $sql = "INSERT INTO usuarios (nombre, email, contrasenia) VALUE (:nombre, :email,:contrasenia)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nombre",$input['nombre'] );
        $stmt->bindParam(":email",$input['email'] );
        $stmt->bindParam(":contrasenia",$input['contrasenia'] );
        $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $this->conn->lastInsertId();

    }

<<<<<<< HEAD
    public function ObtenerCampo($campo, $valor = null){
    $permitidos = ["id", "email", "contrasenia", "rol"];

    if(!in_array($campo, $permitidos)){
        return null;
    }

    if($valor === null){
        // SELECT campo FROM usuarios
        $sql = "SELECT $campo FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // SELECT * FROM usuarios WHERE campo = :valor
        $sql = "SELECT * FROM usuarios WHERE $campo = :valor";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":valor", $valor);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
=======


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

    
>>>>>>> 154dc7b9be973b54b801382f15d8611af19254df
}

?>