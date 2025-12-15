<?php
 class LibroModelo {
    private PDO $conn;
    public function __construct(PDO $pdo){
            $this->conn= $pdo;
        }
    public function agregar(string $nombre, string $autor, int $categoria):void{
        $sql = "INSERT INTO libros (titulo, autor, id_categoria) VALUES (:nombre, :autor, :categoria)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':categoria', $categoria);
        $stmt -> execute();
    }
    public function obtenerTodos():array{
        $sql = "SELECT * FROM  libros ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();
        return $stmt -> fetchAll();    
    }
    public function obtenerTodosId($id):array{
        $sql = "SELECT * FROM  libros WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();
        return $stmt -> fetchAll();    
    }
    public function eliminarLibro(int $id)
    {
        // Primero elimina los comentarios relacionados
        $sqlComentarios = "DELETE FROM comentarios WHERE id_libro = :id";
        $stmtComentarios = $this->conn->prepare($sqlComentarios);
        $stmtComentarios->bindParam(":id", $id, PDO::PARAM_INT);
        $stmtComentarios->execute();
    
        // Luego elimina el libro
        $sql = "DELETE FROM libros WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function actualizarLibro( string $nuevoTitulo, string $nuevoAutor, int $nuevaCategoria, int $id): void
    {
        $sql = "UPDATE libros SET titulo = :nuevoTitulo, autor = :nuevoAutor, id_categoria = :nuevaCategoria WHERE  id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nuevoTitulo', $nuevoTitulo);
        $stmt->bindParam(':nuevoAutor', $nuevoAutor);
        $stmt->bindParam(':nuevaCategoria', $nuevaCategoria);
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
    }

    public function obtenerPorIdyCategoria(int $id, string $relacion): ?array
{
    // Validamos relación
    if ($relacion !== 'categorias') {
        return null; // o puedes devolver un array con error
    }

    // Query
    $sql = "SELECT libros.id, libros.titulo, categorias.nombre AS categoria_nombre
            FROM libros 
            LEFT JOIN categorias ON categorias.id = libros.id_categoria 
            WHERE libros.id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultado ?: null;
}
    public function obtenerLibrosPaginados(int $limit, int $page): array
    {
        $page = ($page - 1) * $limit;
        $sql = "SELECT id, titulo FROM libros LIMIT :limit OFFSET :page";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':page', $page, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerLibrosOrdenados(string $orden): array
    {
        $ordenValido = in_array(strtoupper($orden), ['ASC', 'DESC']) ? strtoupper($orden) : 'ASC';
        $sql = "SELECT * FROM libros ORDER BY id $ordenValido";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerLibrosBuscados(string $search): array
    {
        $sql = "SELECT * FROM libros WHERE titulo LIKE :search OR autor LIKE :search";
        $stmt = $this->conn->prepare($sql);
        $likeSearch = '%' . $search . '%';
        $stmt->bindParam(':search', $likeSearch, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetchAll();
    }

        public function obtenerTodosLibrosCategorias(int $id_categoria): array
    {
        $sql = "SELECT * FROM libros WHERE id_categoria = :id_categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
?>