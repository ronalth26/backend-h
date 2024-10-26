<?php
include_once './config/Database.php';
include_once './models/Valoracion.php';

class ValoracionesController {
    private $db;
    private $requestMethod;
    private $solicitudId;
    private $puntuacionCliente;
    private $comentarioCliente;
    private $puntuacionEspecialista;
    private $comentarioEspecialista;
    private $idCliente;
    private $idEspecialista;
    private $action;

    private $valoracion;

    public function __construct($db, $requestMethod, $solicitudId = null, $puntuacionCliente = null, $comentarioCliente = null, $puntuacionEspecialista = null, $comentarioEspecialista = null, $idCliente = null, $idEspecialista = null,$action = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->solicitudId = $solicitudId;
        $this->puntuacionCliente = $puntuacionCliente;
        $this->comentarioCliente = $comentarioCliente;
        $this->puntuacionEspecialista = $puntuacionEspecialista;
        $this->comentarioEspecialista = $comentarioEspecialista;
        $this->idCliente = $idCliente;
        $this->idEspecialista = $idEspecialista;
        $this->action = $action;

        $this->valoracion = new Valoracion($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idCliente) {
                    $response = $this->traerValoracionesCliente($this->idCliente);
                } else if ($this->idEspecialista) {
                    $response = $this->traerValoracionesEspecialista($this->idEspecialista);
                }  else {
                    $response = $this->notFoundResponse(); 
                }
                break;
            case 'PUT':
                if ($this->action == 'actualizar_valoracion_cliente') {
                    $response = $this->actualizarValoracionCliente();
                } else if ($this->action == 'actualizar_valoracion_especialista') {
                    $response = $this->actualizarValoracionEspecialista();
                } else {
                    $response = $this->notFoundResponse();
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

 

    // private function getValoraciones($solicitudId) {
    //     $result = $this->valoracion->getValoracionesBySolicitudId($solicitudId);
    //     if ($result->rowCount() > 0) {
    //         $response['status_code_header'] = 'HTTP/1.1 200 OK';
    //         $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
    //     } else {
    //         $response = $this->notFoundResponse();
    //     }
    //     return $response;
    // }

    private function actualizarValoracionCliente() {

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    
        $this->valoracion->idSolicitud = $input['idSolicitud'];
        $this->valoracion->puntuacionCliente = $input['puntuacionCliente'];
        $this->valoracion->comentarioCliente = $input['comentarioCliente'];

        if ($this->valoracion->updateValoracionCliente()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['mensaje' => 'Calificación Enviada.','estado' => 1]);
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['mensaje' => 'No se pudo actualizar la valoración del cliente.']);
        }
        return $response;
    }

    private function actualizarValoracionEspecialista() {

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    
        $this->valoracion->idSolicitud = $input['idSolicitud'];
        $this->valoracion->puntuacionEspecialista = $input['puntuacionEspecialista'];
        $this->valoracion->comentarioEspecialista = $input['comentarioEspecialista'];

        if ($this->valoracion->updateValoracionEspecialista()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['mensaje' => 'Calificación Enviada.','estado' => 1]);
        } else {
            $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
            $response['body'] = json_encode(['mensaje' => 'No se pudo actualizar la valoración del especialista.']);
        }
        return $response;
    }

    private function traerValoracionesCliente($idCliente) {
        $result = $this->valoracion->getValoracionesCliente($idCliente);
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function traerValoracionesEspecialista($idEspecialista) {
        $result = $this->valoracion->getValoracionesEspecialista($idEspecialista);
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
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
