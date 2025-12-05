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
        $this->usuarios->actualizarUser("", $nuevoNombre, $nuevoEmail, (int)$id);
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
    public function obtenerPorIdyRelacion(int $id, string $relacion): ?array {
        return $this->usuarios->obtenerPorIdyRelacion($id, $relacion);
    }
}

?>