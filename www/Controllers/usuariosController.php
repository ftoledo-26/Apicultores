<?php
class usuariosController{
    private UsuariosModels $usuarios;

    public function __construct(UsuariosModels $models){
        $this->usuarios = $models;
    }

    public function GetUsusuarios():array{
        return $this->usuarios->obtenerTodos();
    }

    public function PutActualizar($nuevoNombre, $nuevoEmail, $id) :void {

        $this->usuarios->actualizarUser((INT)$id, $nuevoNombre, $nuevoEmail);
        
    }

    public function GetUsuarioById(int $id): ?array {
        return $this->usuarios->obtenerPorId($id);
    }
    public function eliminarusuario(int $id) {
        $this->usuarios->eliminarpersona($id);
    }
    public function ObtenerDatos($campo, $valor = null){
        return $this->usuarios->ObtenerCampo($campo, $valor);
    }
    public function crear($input):int{
        return $this->usuarios->crearUsuario($input);
    }
}

?>