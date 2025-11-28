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

    public function actualizarLibro(): void
    {
        $id = $_POST['id'];
        $nuevoTitulo = $_POST['nuevoTitulo'];
        $nuevoAutor = $_POST['nuevoAutor'];
        $nuevaCategoria = $_POST['nuevaCategoria'];

        $this->libro->actualizarLibro($id, $nuevoTitulo, $nuevoAutor, $nuevaCategoria);
    }
}
?>