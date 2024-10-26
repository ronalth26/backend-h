<?php
class Valoracion {
    private $conn;
    private $table = 'valoracion';

    public $idSolicitud;
    public $puntuacionCliente;
    public $comentarioCliente;
    public $puntuacionEspecialista;
    public $comentarioEspecialista;
    public $idCliente;
    public $idEspecialista;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllServicios() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getValoracionesBySolicitudId($idSolicitud) {
        $query = "SELECT * FROM " . $this->table . " WHERE idSolicitud = :idSolicitud";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idSolicitud', $idSolicitud);
        $stmt->execute();
        return $stmt;
    }

    public function updateValoracionCliente() {
        $this->conn->beginTransaction();
        try {
            // Actualizar valoración del cliente en la tabla valoracion
            $query = "UPDATE " . $this->table . " 
                      SET puntuacionCliente = :puntuacionCliente, 
                          comentarioCliente = :comentarioCliente 
                      WHERE idSolicitud = :idSolicitud";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':puntuacionCliente', $this->puntuacionCliente);
            $stmt->bindParam(':comentarioCliente', $this->comentarioCliente);
            $stmt->bindParam(':idSolicitud', $this->idSolicitud);
            $stmt->execute();

            // Actualizar el estado en la tabla solicitud
            $query = "UPDATE solicitud 
                      SET estado = 3 
                      WHERE idSolicitud = :idSolicitud";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idSolicitud', $this->idSolicitud);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }



    public function updateValoracionEspecialista() {
        $this->conn->beginTransaction();
        try {
            // Actualizar valoración del especialista en la tabla valoracion
            $query = "UPDATE " . $this->table . " 
                      SET puntuacionEspecialista = :puntuacionEspecialista, 
                          comentarioEspecialista = :comentarioEspecialista 
                      WHERE idSolicitud = :idSolicitud";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':puntuacionEspecialista', $this->puntuacionEspecialista);
            $stmt->bindParam(':comentarioEspecialista', $this->comentarioEspecialista);
            $stmt->bindParam(':idSolicitud', $this->idSolicitud);
            $stmt->execute();
    
            // Actualizar el estado en la tabla solicitud
            $query = "UPDATE solicitud 
                      SET calificadaCliente = 1 
                      WHERE idSolicitud = :idSolicitud";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idSolicitud', $this->idSolicitud);
            $stmt->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    
    public function getValoracionesCliente($idCliente) {
        $query = "SELECT v.* FROM " . $this->table . " v
                  INNER JOIN solicitud s ON v.idSolicitud = s.idSolicitud
                  WHERE s.idCliente = :idCliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->execute();
        return $stmt;
    }

    public function getValoracionesEspecialista($idEspecialista) {
        $query = "SELECT v.* FROM " . $this->table . " v
                  INNER JOIN solicitud s ON v.idSolicitud = s.idSolicitud
                  WHERE s.idEspecialista = :idEspecialista";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idEspecialista', $idEspecialista);
        $stmt->execute();
        return $stmt;
    }
}
?>
