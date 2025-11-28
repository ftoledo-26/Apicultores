<?php
 class LibroModelo {
    private PDO $pdo;
//GETTER Y SETTER
    public function setpdo($pdo){
        $this->pdo= $pdo;
    }
    public function getpdo(){
        return $this->pdo;
    }
    //METODOS
    public function __construct(PDO $pdo){
            $this->pdo= $pdo;
        }
    public function agregar(string $nombre){
        $sql = "INSERT INTO libro(nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt -> execute();
    }
    public function todos():array{
        $sql = "SELECT * FROM  libro";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();
        $todo = $stmt -> fetchAll();
        return $todo;
    }

    public function actualizarLibro(int $id, string $nuevoTitulo, string $nuevoAutor, string $nuevaCategoria): void
    {
        $sql = "UPDATE libros SET titulo = :nuevoTitulo, autor = :nuevoAutor, id_categoria = :nuevaCategoria WHERE  id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nuevoTitulo', $nuevoTitulo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>