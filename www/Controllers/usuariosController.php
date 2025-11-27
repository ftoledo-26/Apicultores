<?php
require_once __DIR__ . '/../Models/UsuariosModels.php';
class usuariosController{
    private UsuariosModels $usuarios;

    public function __construct(UsuariosModels $models){
        $this->usuarios = $models;
    }

    public function GetUsusuarios():array{
        return $this->usuarios->obtenerTodos();
    }

    public function PutActualizar() :void {
        $this->usuarios->actualizarUser();
        
    }

}

?>