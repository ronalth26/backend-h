<?php
include_once './config/Database.php';
include_once './models/Publicacion.php';

class PublicacionController {
    private $db;
    private $requestMethod;
    private $id;
    private $usuario_id;

    private $publicacion;

    public function __construct($db, $requestMethod, $id = null, $usuario_id = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->id = $id;
        $this->usuario_id = $usuario_id;

        $this->publicacion = new Publicacion($db);
    }


    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->id) {
                    $response = $this->getPublicacion($this->id);
                } else if ($this->usuario_id) {
                    $response = $this->getPublicacionById($this->usuario_id);
                } else {
                    $response = $this->getAllPublicacion();
                }
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

    private function getAllPublicacion() {
        $result = $this->publicacion->getAllPublicacion();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        return $response;
    }

    private function getPublicacionById($id) {
        $this->publicacion->id = $id;
        $result = $this->publicacion->getPublicacionById();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function getPublicacion($id) {
        $this->publicacion->id = $id;
        $result = $this->publicacion->getPublicacionById();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetch(PDO::FETCH_ASSOC));
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['mensaje' => 'Recurso no encontrado.']);
        return $response;
    }
}
?>
