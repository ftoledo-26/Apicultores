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
        $stmt->bindParam(":password", $passw); // Crear funcion para cifrar si no encontramos

        $stmt->execute();
    }
     public function obtenerTodos(): array
    {
        $sql = "SELECT id, nombre, email FROM empleados";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute(); // No hay parámetros, pero igual se ejecuta
        return $stmt->fetchAll();
    }
}

?>