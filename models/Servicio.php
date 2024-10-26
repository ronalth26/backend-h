<?php
class Servicio {
    private $conn;
    private $table = 'servicio';

    public $idServicio;
    public $idCategoria;
    public $nombreServicio;
    public $descripcion;
    public $precio;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllServicios() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getServiciosByCategoria() {
        $query = "SELECT * FROM " . $this->table . " WHERE idCategoria = :idCategoria";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCategoria', $this->idCategoria);
        $stmt->execute();
        return $stmt;
    }

    public function getServicioById() {
        $query = "SELECT * FROM " . $this->table . " WHERE idServicio = :idServicio";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idServicio', $this->idServicio);
        $stmt->execute();
        return $stmt;
    }
}
?>
