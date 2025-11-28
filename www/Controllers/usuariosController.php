<?php
class usuariosController{
    private UsuariosModels $usuarios;

    public function __construct(UsuariosModels $models){
        $this->usuarios = $models;
    }

    public function GetUsusuarios():array{
        return $this->usuarios->obtenerTodos();
    }

    public function PutActualizar() :void {
        $nuevoNombre = $_POST['nuevoNombre'];
        $nuevoEmail = $_POST['nuevoEmail'];
        $nombre = $_POST['nombre'];
        $this->usuarios->actualizarUser($nombre, $nuevoNombre, $nuevoEmail);
        
    }

    public function GetUsuarioById(int $id): ?array {
        return $this->usuarios->obtenerPorId($id);
    }
    public function eliminarusuario(int $id) {
        $this->usuarios->eliminarpersona($id);
    }
}

?>