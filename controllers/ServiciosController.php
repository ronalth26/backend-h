<?php
include_once './config/Database.php';
include_once './models/Servicio.php';

class ServiciosController {
    private $db;
    private $requestMethod;
    private $servicioId;
    private $categoriaId;

    private $servicio;

    public function __construct($db, $requestMethod, $servicioId = null, $categoriaId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->servicioId = $servicioId;
        $this->categoriaId = $categoriaId;

        $this->servicio = new Servicio($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->servicioId) {
                    $response = $this->getServicio($this->servicioId);
                } else if ($this->categoriaId) {
                    $response = $this->getServiciosByCategoria($this->categoriaId);
                } else {
                    $response = $this->getAllServicios();
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

    private function getAllServicios() {
        $result = $this->servicio->getAllServicios();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        return $response;
    }

    private function getServiciosByCategoria($idCategoria) {
        $this->servicio->idCategoria = $idCategoria;
        $result = $this->servicio->getServiciosByCategoria();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function getServicio($id) {
        $this->servicio->idServicio = $id;
        $result = $this->servicio->getServicioById();
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
