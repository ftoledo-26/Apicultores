<?php
class categoriasModels{
    private PDO $conn;
    public function __construct(PDO $pdo){
        $this->conn=$pdo;
    }
    public function ObtenerTodos():array{
        $sql ="SELECT * FROM categorias";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt-> execute();
        return $stmt->fetchAll();
    }
    public function ObtenerTodosPorId($id):array{
        $sql = "SELECT * FROM categorias WHERE id = :id";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>