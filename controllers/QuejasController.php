<?php
include_once './config/Database.php';
include_once './models/Queja.php';

class QuejasController {
    private $db;
    private $requestMethod;
    private $quejaId;

    private $queja;

    public function __construct($db, $requestMethod, $quejaId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->quejaId = $quejaId;

        $this->queja = new Queja($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createQueja();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function createQueja() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        // if (!$this->validateQueja($input)) {
        //     return $this->unprocessableEntityResponse('Todos los campos son obligatorios');
        // }

        $this->queja->idCliente = $_POST['idCliente'];
        $this->queja->idSolicitud = $_POST['idSolicitud'];
        $this->queja->motivo = $_POST['motivo'];
        $this->queja->descripcion = $_POST['descripcion'];
       // Handle file upload
       if (!empty($_FILES['imagen'])) {
           $file = $_FILES['imagen'];
           $filename = $_POST['idCliente'] . '_' . $_POST['idSolicitud'] . '_' . basename($file['name']);
           $target_dir = "quejas/";
           $target_file = $target_dir . $filename;
       
           // Create the directory if it doesn't exist
           if (!file_exists($target_dir)) {
               mkdir($target_dir, 0777, true);
           }
       
           if (move_uploaded_file($file['tmp_name'], $target_file)) {
               $this->queja->imagen = $target_file;
           } else {
               return $this->unprocessableEntityResponse('Error al subir la imagen');
           }
       } else {
         $this->queja->imagen = "";
       }
    
 
        if ($this->queja->createQueja()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(['mensaje' => 'Queja registrada correctamente', 'estado' => 1]);
        } else {
            $response = $this->unprocessableEntityResponse('Error al registrar la queja');
        }

        return $response;
    }

    private function validateQueja($input) {
        return isset($input['idCliente'], $input['idSolicitud'], $input['motivo'], $input['descripcion']);
    }

    private function unprocessableEntityResponse($message = "Datos invalidos.") {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['mensaje' => $message]);
        return $response;
    }

    private function notFoundResponse($message = "Recurso no encontrado.") {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['mensaje' => $message]);
        return $response;
    }
}
?>