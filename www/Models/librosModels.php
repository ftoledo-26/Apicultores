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
}
?>