<?php
class Categoria {
    private $conn;
    private $table = 'categoria';

    public $idCategoria;
    public $nombreCategoria;
    public $count;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCategorias() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getCategoriaById() {
        $query = "SELECT * FROM " . $this->table . " WHERE idCategoria = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->idCategoria);
        $stmt->execute();
        return $stmt;
    }
}
?>
