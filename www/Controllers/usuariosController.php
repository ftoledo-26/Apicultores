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
        $id = $_POST['id'];
        $this->usuarios->actualizarUser($id, $nuevoNombre, $nuevoEmail);
        
    }

    public function GetUsuarioById(int $id): ?array {
        return $this->usuarios->obtenerPorId($id);
    }
    public function eliminarusuario(int $id) {
        $this->usuarios->eliminarpersona($id);
    }
    public function ObtenerDatos(...$argv){
        return $this->usuarios->ObtenreCampo($argv);
    }
}

?>