<?php
 class LibroModelo {
    private PDO $conn;
//GETTER Y SETTER
    public function setconn($conn){
        $this->conn= $conn;
    }
    public function getconn(){
        return $this->conn;
    }
    //METODOS
    public function __construct(PDO $conn){
            $this->conn= $conn;
        }
    public function agregar(string $nombre){
        $sql = "INSERT INTO libro(nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt -> execute();
    }
    public function todos():array{
        $sql = "SELECT * FROM  libro";
        $stmt = $this->conn->prepare($sql);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();
        $todo = $stmt -> fetchAll();
        return $todo;
    }
    public function eliminarLibro(int $id)
    {
        $sql = "DELETE FROM  libro WHERE libro=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>