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
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getComentariosByUserId($id){
        $sql = "SELECT * FROM comentarios C
                INNER JOIN usuarios U on U.id = C.id_usuario
                WHERE U.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt-> bindParam(":id", $id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function eliminarComentario(int $id)
    {
        $sql = "DELETE FROM comentarios WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function actualizarComentario(string $comentario, int $id){
        $sql = "UPDATE comentarios SET comentario = :comentario, fecha = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>