<?php

class comentarios{
    private PDO $conn;

    public function __construct(PDO $conn){
        $this->conn = $conn;
    }

    public function aniadirComentario($comentario){
        $sql = "INSERT INTO comentarios (texto) VALUES (:comentario)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->execute();
    }

    public function getComentarios(){
        $sql = "SELECT * FROM comentarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}

?>