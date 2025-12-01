<?php
class controladorComentarios{
    private comentarios $comentariosModel ;
    
    public function __construct(comentarios $comentariosModel){
    $this->comentariosModel = $comentariosModel;
    
    }
<<<<<<< HEAD
=======

>>>>>>> deacc6e3b39027c68f9ce1a87ef9814c7e16d2bb
    public function GetComentario(){
        return $this->comentariosModel->getComentarios();
    }
    public function GetComentarioUserId($id){
        return $this->comentariosModel->getComentariosByUserId($id);
<<<<<<< HEAD
=======
    }

    public function PutComentario(){
        $id = $_POST['id'];
        $comentario = $_POST['comentario'];
        $this->comentariosModel->actualizarComentario($id, $comentario);
>>>>>>> deacc6e3b39027c68f9ce1a87ef9814c7e16d2bb
    }
    public function eliminarComentario(int $id) {
            $this->comentariosModel->eliminarComentario($id);
        }
}


?>

