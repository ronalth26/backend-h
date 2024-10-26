<?php
class User {
    private $conn;
    private $table_name = "usuarios";
    private $table_especialista = "especialista";



    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $contrasena;


    public $idUsuario;
    public $fechaNacimiento;
    public $documentoIdentidad;
    public $especialidades;
    public $indentificacion;
    public $dni_frente;
    public $dni_atras;
    public $confirmacion;
    public $antecedentes;
    public $evidencias;



    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getUserById() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function createUser() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, apellido, telefono, email, contrasena) VALUES (:nombre, :apellido, :telefono, :email, :contrasena)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contrasena', $this->contrasena);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateUser() {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, contrasena = :contrasena WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contrasena', $this->contrasena);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function deleteUser() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function checkEmailExists() {
        $query = "SELECT email FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt;
    }

    public function loginUser() {
        $query = "SELECT id, especialista,email, nombre, apellido FROM " . $this->table_name . " WHERE email = :email AND contrasena = :contrasena";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contrasena', $this->contrasena);
        $stmt->execute();
        return $stmt;
    }


    
    public function crearEspecialista() {
        $query = "INSERT INTO " . $this->table_especialista . " (idEspecialista, especialidades, fotoIdentificacion, fotoDniFrente, fotoDniTrasera, confirmacionIdentidad, antecedentesNoPenales, evidenciasTrabajos) VALUES (:idEspecialista, :especialidades, :fotoIdentificacion, :fotoDniFrente, :fotoDniTrasera, :confirmacionIdentidad, :antecedentesNoPenales, :evidenciasTrabajos)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':idEspecialista', $this->idUsuario);
        $stmt->bindParam(':especialidades', $this->especialidades);
        $stmt->bindParam(':fotoIdentificacion', $this->indentificacion);
        $stmt->bindParam(':fotoDniFrente', $this->dni_frente);
        $stmt->bindParam(':fotoDniTrasera', $this->dni_atras);
        $stmt->bindParam(':confirmacionIdentidad', $this->confirmacion);
        $stmt->bindParam(':antecedentesNoPenales', $this->antecedentes);
        $stmt->bindParam(':evidenciasTrabajos', $this->evidencias);
    
        if ($stmt->execute()) {
            // Actualizar el campo especialista en la tabla usuarios
            $updateQuery = "UPDATE usuarios SET especialista = 1 WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':id', $this->idUsuario);
    
            if ($updateStmt->execute()) {
                return true;
            }
        }
    
        return false;
    }
    

}
?>
