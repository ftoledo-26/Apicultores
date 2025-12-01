<?php
 class LibroModelo {
    private PDO $conn;
    public function __construct(PDO $pdo){
            $this->conn= $pdo;
        }
    public function agregar(string $nombre){
        $sql = "INSERT INTO libro(nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt -> execute();
    }
    public function obtenerTodos():array{
        $sql = "SELECT * FROM  libros";
        $stmt = $this->conn->prepare($sql);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();
        return $stmt -> fetchAll();    
    }
    public function obtenerTodosId($id):array{
        $sql = "SELECT * FROM  libros WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();
        return $stmt -> fetchAll();    
    }

    public function actualizarLibro( string $nuevoTitulo, string $nuevoAutor, int $nuevaCategoria, int $id): void
    {
        $sql = "UPDATE libros SET titulo = :nuevoTitulo, autor = :nuevoAutor, id_categoria = :nuevaCategoria WHERE  id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nuevoTitulo', $nuevoTitulo);
        $stmt->bindParam(':nuevoAutor', $nuevoAutor);
        $stmt->bindParam(':nuevaCategoria', $nuevaCategoria);
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
    }
}
?>