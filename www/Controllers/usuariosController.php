<?php
class usuariosController{
    private UsuariosModels $usuarios;

    public function __construct(UsuariosModels $models){
        $this->usuarios = $models;
    }

    public function GetUsusuarios():array{
        return $this->usuarios->obtenerTodos();
    }

    public function GetUsuariosPaginados(int $limit, int $page): array{
        return $this->usuarios->obtenerUsuariosPaginados($limit, $page);
    }

    public function PutActualizar($nuevoNombre, $nuevoEmail, $id) :void {

        $this->usuarios->actualizarUser((INT)$id, $nuevoNombre, $nuevoEmail);
        
    }

    public function GetUsuarioById(int $id): ?array {
        return $this->usuarios->obtenerPorId($id);
    }


}

?>