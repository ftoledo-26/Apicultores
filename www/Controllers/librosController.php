<?php
 class librosController {
    private LibroModelo $libro;

    //METODOS
    public function __construct(libroModelo $libro){
            $this->libro= $libro;
        }
    public function ejecutar():array{
        $this->libro->agregar("Metro2033");
        $this->libro->agregar("The witcher");
        $libro= $this->libro->todos();
        return $datos =["libro"=>$libro];
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