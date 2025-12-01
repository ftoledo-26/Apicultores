<?php
 class librosController {
    private LibroModelo $libro;

    //METODOS
    public function __construct(libroModelo $libro){
            $this->libro= $libro;
        }
    public function GetLibros():array{
        return $this->libro->obtenerTodos();
    }
    public function GetLibrosById($id):array {
        return $this->libro->obtenerTodosId($id);
    }

    public function actualizarLibro( $nuevoTitulo, $nuevoAutor, $nuevaCategoria, $id): void
    {
        $this->libro->actualizarLibro($nuevoTitulo, $nuevoAutor, (INT)$nuevaCategoria, (INT)$id);
    }
}
?>