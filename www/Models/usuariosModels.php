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

    public function actualizarUser(string $nombreActual, string $nuevoNombre, string $nuevoEmail): void
    {
<<<<<<< HEAD
        $sql = "UPDATE empleados SET nombre = :nuevoNombre, email = :nuevoEmail WHERE nombre = :nombreActual";
=======
        $sql = "UPDATE usuarios SET nombre = :nuevoNombre, email = :nuevoEmail WHERE id = :id";
>>>>>>> deacc6e3b39027c68f9ce1a87ef9814c7e16d2bb
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nuevoNombre', $nuevoNombre);
        $stmt->bindParam(':nuevoEmail', $nuevoEmail);
<<<<<<< HEAD
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
=======
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
>>>>>>> deacc6e3b39027c68f9ce1a87ef9814c7e16d2bb
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

    public function ObtenreCampo(...$argv):array{
        $variables = count($argv);
        switch($variables){
            case 1:
                $sql = "SELECT :campo FROM usuarios";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":campo", $argv[0]);
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $stmt -> execute();
                return $stmt -> fetchAll(PDO::FETCH_ASSOC);
            break;

            case 2:
                $sql = "SELECT :campo FROM usuarios where :campo = :valor";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":campo", $argv[0]);
                $stmt ->bindParam(":valor",$argv[1]);
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                $stmt -> execute();
                return $stmt -> fetchAll(PDO::FETCH_ASSOC); 
            break;
            
            default:
                echo "<script>alert('No has introducido los valores adecuados');</script>";
                return [];
            break;
        }
            
        
        
    }
}

?>