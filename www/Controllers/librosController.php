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
    public function eliminaLibro(int $id) {
        $this->libro->eliminarLibro($id);
    }
}
?>