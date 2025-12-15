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
    public function eliminarLibro(int $id) {
        $this->libro->eliminarLibro($id);
    }

    public function GetLibrosPaginados(int $limit, int $page): array{
        return $this->libro->obtenerLibrosPaginados($limit, $page);
    }

    public function GetLibrosOrdenados(string $orden): array{
        return $this->libro->obtenerLibrosOrdenados($orden);
    }



    public function GetLibrosBuscados(string $search): array{
        return $this->libro->obtenerLibrosBuscados($search);
    }

    public function GetLibrosCategorizados(int $id_categoria): array{
        return $this->libro->obtenerTodosLibrosCategorias($id_categoria);
    }

    public function actualizarLibro( $nuevoTitulo, $nuevoAutor, $nuevaCategoria, $id): void
    {
        $this->libro->actualizarLibro($nuevoTitulo, $nuevoAutor, (INT)$nuevaCategoria, (INT)$id);
    }
    public function obtenerPorIdyCategoria(int $id, string $relacion): ?array {
        return $this->libro->obtenerPorIdyCategoria($id, $relacion);
    }
    
    public function crearLibro(string $titulo, string $autor, int $categoria): void {
        $this->libro->agregar($titulo, $autor, $categoria);
    }
    public function export(string $ruta){
        $this->libro->export($ruta);
    }
    public function cantidadLibros(): int {
        return $this->libro->cantidadLibros();  
    }
}
?>