<?php
class controladorComentarios{
    private comentarios $comentariosModel ;
    
    public function __construct(comentarios $comentariosModel){
    $this->comentariosModel = $comentariosModel;
    
    }
    public function GetComentario(){
        return $this->comentariosModel->getComentarios();
    }
    public function GetComentarioUserId($id){
        return $this->comentariosModel->getComentariosByUserId($id);
    }

    public function PutComentario(){
        $id = $_POST['id'];
        $comentario = $_POST['comentario'];
        $this->comentariosModel->actualizarComentario($id, $comentario);
    }
    public function eliminarComentario(int $id) {
            $this->comentariosModel->eliminarComentario($id);
        }
}


?>

