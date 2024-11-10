<?php
class Publicacion {
    private $conn;
    private $table = 'publicacion';

    public $categoria;
    public $titulo;
    public $fecha;
    public $distrito;
    public $descripcion;
    public $imagen;
    public $id;
    public $usuario_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllPublicacion() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getPublicacionById() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getPublicacionByUsuario_id() {
        $query = "SELECT * FROM " . $this->table . " WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
