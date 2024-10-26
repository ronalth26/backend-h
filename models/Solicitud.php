<?php
class Solicitud {
    private $conn;
    private $table = 'solicitud';
    private $tabla_negociacion = 'negociacion_temp';
    private $tabla_valoracion = 'valoracion';

    public $idSolicitud;
    public $idCliente;
    public $idEspecialista;
    public $idServicio;
    public $descripcion;
    public $ubicacion;
    public $lat_long;
    public $fechaHoraSolicitud;
    public $fechaHoraAtencion;
    public $precio;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllSolicitudes() {
        $query = "SELECT s.*, srv.* , usr.nombre, usr.apellido, usr.telefono
                  FROM " . $this->table . " s
                  INNER JOIN usuarios usr ON s.idCliente = usr.id
                  INNER JOIN servicio srv ON s.idServicio = srv.idServicio";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    // public function getAllNegociaciones() {
    //     $query = "SELECT s.*, usr.nombre, usr.apellido, COALESCE(AVG(v.puntuacionEspecialista), 0) as promedioPuntuacion
    //               FROM " . $this->tabla_negociacion . " s
    //               INNER JOIN usuarios usr ON s.idEspecialista = usr.id
    //               LEFT JOIN valoracion v ON s.idSolicitud = v.idSolicitud
    //               WHERE s.idSolicitud = :idSolicitud
    //               GROUP BY s.idEspecialista, usr.nombre, usr.apellido";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':idSolicitud', $this->idSolicitud);
    //     $stmt->execute();
    //     return $stmt;
    // }
    
    // public function getAllNegociaciones() {
    //     $query = "SELECT s.*, usr.nombre, usr.apellido, AVG(v.puntuacionEspecialista) as promedioPuntuacion
    //               FROM negociacion_temp s
    //               INNER JOIN usuarios usr ON s.idEspecialista = usr.id
    //               INNER JOIN valoracion v ON v.idSolicitud IN (SELECT idSolicitud FROM solicitud WHERE idEspecialista = s.idEspecialista)
    //               WHERE s.idSolicitud = :idSolicitud
    //               GROUP BY s.idSolicitud, usr.nombre, usr.apellido;
    //               ";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':idSolicitud', $this->idSolicitud);
    //     $stmt->execute();
    //     return $stmt;
    // }


    public function getAllNegociaciones() {
        $query = "SELECT s.*, usr.nombre, usr.apellido, COALESCE(AVG(v.puntuacionEspecialista), 0) as promedioPuntuacion
                  FROM negociacion_temp s
                  INNER JOIN usuarios usr ON s.idEspecialista = usr.id
                  LEFT JOIN valoracion v ON v.idSolicitud IN (SELECT idSolicitud FROM solicitud WHERE idEspecialista = s.idEspecialista)
                  WHERE s.idSolicitud = :idSolicitud
                  GROUP BY s.idSolicitud, usr.nombre, usr.apellido;
                  ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idSolicitud', $this->idSolicitud);
        $stmt->execute();
        return $stmt;
    }
    


    public function getSolicitudById() {
        $query = "SELECT s.*, s.idCliente as id_cliente, srv.*, usr.nombre, usr.apellido, usr.telefono,esp.nombre as nombre_es, esp.apellido as apellido_es
                  FROM " . $this->table . " s
                  INNER JOIN servicio srv ON s.idServicio = srv.idServicio
                  INNER JOIN usuarios usr ON s.idCliente = usr.id
                  INNER JOIN usuarios esp ON s.idEspecialista = esp.id
                  WHERE s.idSolicitud = :idSolicitud";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idSolicitud', $this->idSolicitud);
        $stmt->execute();
        return $stmt;
    }
    

    
    public function getSolicitudesByCliente() {
        $query = "SELECT s.*, srv.* 
                  FROM " . $this->table . " s
                  INNER JOIN servicio srv ON s.idServicio = srv.idServicio
                  WHERE s.idCliente = :idCliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCliente', $this->idCliente);
        $stmt->execute();
        return $stmt;
    }
    
    public function getSolicitudesByEspecialista() {
        $query = "SELECT s.*, srv.* , usr.nombre, usr.apellido, usr.telefono
                  FROM " . $this->table . " s
                  INNER JOIN usuarios usr ON s.idCliente = usr.id
                  INNER JOIN servicio srv ON s.idServicio = srv.idServicio
                  WHERE s.idEspecialista = :idEspecialista";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idEspecialista', $this->idEspecialista);
        $stmt->execute();
        return $stmt;
    }
    

    public function getSolicitudesByServicio() {
        $query = "SELECT * FROM " . $this->table . " WHERE idServicio = :idServicio";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idServicio', $this->idServicio);
        $stmt->execute();
        return $stmt;
    }

    public function createSolicitud() {
        $query = "INSERT INTO " . $this->table . " (idCliente,idServicio, descripcion, ubicacion,lat_long, fechaHoraSolicitud, precio, estado) VALUES (:idCliente,:idServicio, :descripcion, :ubicacion,:lat_long, :fechaHoraSolicitud, :precio, 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCliente', $this->idCliente);
        $stmt->bindParam(':idServicio', $this->idServicio);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':lat_long', $this->lat_long);
        $stmt->bindParam(':fechaHoraSolicitud', $this->fechaHoraSolicitud);
        $stmt->bindParam(':precio', $this->precio);
        return $stmt->execute();
    }

    public function negociarSolicitud() {
   
        $this->conn->beginTransaction();
    
        try {
            // Verificar si existe solicitud
            $checkQuery = "SELECT * FROM " . $this->tabla_negociacion . " WHERE idSolicitud = :idSolicitud AND idEspecialista = :idEspecialista";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':idSolicitud', $this->idSolicitud);
            $checkStmt->bindParam(':idEspecialista', $this->idEspecialista);
            $checkStmt->execute();
            
            // Si existe se borra
            if ($checkStmt->rowCount() > 0) {
                $deleteQuery = "DELETE FROM " . $this->tabla_negociacion . " WHERE idSolicitud = :idSolicitud AND idEspecialista = :idEspecialista";
                $deleteStmt = $this->conn->prepare($deleteQuery);
                $deleteStmt->bindParam(':idSolicitud', $this->idSolicitud);
                $deleteStmt->bindParam(':idEspecialista', $this->idEspecialista);
                $deleteStmt->execute();
            }
    
            // INSERTAR EL NUEVO REGISTRO
            $insertQuery = "INSERT INTO " . $this->tabla_negociacion . " (idSolicitud, idCliente, idEspecialista, precio) VALUES (:idSolicitud, :idCliente, :idEspecialista, :precio)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bindParam(':idSolicitud', $this->idSolicitud);
            $insertStmt->bindParam(':idCliente', $this->idCliente);
            $insertStmt->bindParam(':idEspecialista', $this->idEspecialista);
            $insertStmt->bindParam(':precio', $this->precio);
            $insertStmt->execute();
    
        
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
      
            $this->conn->rollBack();
            return false;
        }
    }
    
    public function updateSolicitud() {
        $query = "UPDATE " . $this->table . " 
                  SET descripcion = :descripcion, 
                      ubicacion = :ubicacion, 
                      fechaHoraSolicitud = :fechaHoraSolicitud, 
                      precio = :precio, 
                      estado = :estado 
                  WHERE idSolicitud = :idSolicitud";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':fechaHoraSolicitud', $this->fechaHoraSolicitud);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':idSolicitud', $this->idSolicitud);
        return $stmt->execute();
    }

 
    public function updateSolicitudAceptada() {

        $this->conn->beginTransaction();
    
        try {
            // ACTUALIZAR SOLICITUD
            $updateQuery = "UPDATE " . $this->table . " 
                            SET idEspecialista = :idEspecialista, 
                                precio = :precio, 
                                estado = :estado 
                            WHERE idSolicitud = :idSolicitud";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':idEspecialista', $this->idEspecialista);
            $updateStmt->bindParam(':precio', $this->precio);
            $updateStmt->bindParam(':estado', $this->estado);
            $updateStmt->bindParam(':idSolicitud', $this->idSolicitud);
            $updateStmt->execute();
    
            // BORRAR from tabla_negociacion
            $deleteQuery = "DELETE FROM " . $this->tabla_negociacion . " WHERE idSolicitud = :idSolicitud";
            $deleteStmt = $this->conn->prepare($deleteQuery);
            $deleteStmt->bindParam(':idSolicitud', $this->idSolicitud);
            $deleteStmt->execute();
    
            // INSETAR LA VALORACION
            $insertQuery = "INSERT INTO " . $this->tabla_valoracion . " (idSolicitud) VALUES (:idSolicitud)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bindParam(':idSolicitud', $this->idSolicitud);
            $insertStmt->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }


    public function updateValoracionEspecialista() {
        $query = "UPDATE " . $this->table . " 
                  SET descripcion = :descripcion, 
                      ubicacion = :ubicacion, 
                      fechaHoraSolicitud = :fechaHoraSolicitud, 
                      precio = :precio, 
                      estado = :estado 
                  WHERE idSolicitud = :idSolicitud";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':fechaHoraSolicitud', $this->fechaHoraSolicitud);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':idSolicitud', $this->idSolicitud);
        return $stmt->execute();
    }

    
    



}
?>
