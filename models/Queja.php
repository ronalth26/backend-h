<?php
class Queja {
    private $conn;
    private $table = 'queja';

    public $idQueja;
    public $idCliente;
    public $idSolicitud;
    public $motivo;
    public $descripcion;
    public $imagen;
    public $fechaHoraRegistro;

    public function __construct($db) {
        $this->conn = $db;
    } 

    public function createQueja() {
        $query = "INSERT INTO " . $this->table . " (idUsuario, idSolicitud, motivo, detalle, evidencia, fechaHoraRegistro) VALUES (:idUsuario, :idSolicitud, :motivo, :detalle, :evidencia, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsuario', $this->idCliente);
        $stmt->bindParam(':idSolicitud', $this->idSolicitud);
        $stmt->bindParam(':motivo', $this->motivo);
        $stmt->bindParam(':detalle', $this->descripcion);
        $stmt->bindParam(':evidencia', $this->imagen);
        return $stmt->execute();
    }
}
?>