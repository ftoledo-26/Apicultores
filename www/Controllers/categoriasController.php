<?php
class categoriasController{
    private categoriasModels $cate;

    public function __construct(categoriasModels $categoria){
        $this->cate = $categoria;
    }

    public function ObtenerCategorias():array{
        return $this->cate->ObtenerTodos();
    }
    public function ObtenerCategoriasId($id):array{
        return $this->cate->ObtenerTodosPorId($id);
    }
}



?> 