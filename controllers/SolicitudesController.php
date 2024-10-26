<?php
include_once './config/Database.php';
include_once './models/Solicitud.php';

class SolicitudesController {
    private $db;
    private $requestMethod;
    private $solicitudId;
    private $clienteId;
    private $especialistaId;
    private $servicioId;
    private $negociaciones;
    private $action;

    private $solicitud;

    public function __construct($db, $requestMethod, $solicitudId = null, $clienteId = null,$especialistaId = null, $servicioId = null,$negociaciones = null,$action) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->solicitudId = $solicitudId;
        $this->clienteId = $clienteId;
        $this->especialistaId = $especialistaId;
        $this->servicioId = $servicioId;
        $this->negociaciones = $negociaciones;
        $this->action = $action;

        $this->solicitud = new Solicitud($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->solicitudId && $this->action == 'traer_solicitud') {
                    $response = $this->getSolicitud($this->solicitudId);
                } else if ($this->clienteId) {
                    $response = $this->getSolicitudesByCliente($this->clienteId);
                } else if ($this->especialistaId) {
                    $response = $this->getSolicitudesByEspecialista($this->especialistaId);
                } else if ($this->servicioId) {
                    $response = $this->getSolicitudesByServicio($this->servicioId);
                } else if($this->negociaciones){
                    $response = $this->getAllNegociaciones($this->negociaciones);
                } else{
                    $response = $this->getAllSolicitudes();
                }
                break;
            case 'POST':
                if($this->action == 'crear_solicitud'){
                    $response = $this->createSolicitud();
                } else if($this->action == 'negociar_solicitud'){
                    $response = $this->negociarSolicitud();
                } else {
                    $response = $this->unprocessableEntityResponse('Falta parametro action para procesar la solicitud');
                }
             
                break;
            case 'PUT':
                if ($this->solicitudId) {
                    $response = $this->updateSolicitud($this->solicitudId);
                } else if ($this->action == 'aceptar_solicitud'){
                    $response = $this->updateSolicitudAceptada();
                } else {
                    $response = $this->unprocessableEntityResponse('Falta id de la solicitud para actualizar');
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

    private function getAllSolicitudes() {
        $result = $this->solicitud->getAllSolicitudes();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        return $response;
    }
    private function getAllNegociaciones($id) {
        $this->solicitud->idSolicitud = $id;
        $result = $this->solicitud->getAllNegociaciones();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        return $response;
    }

    private function getSolicitud($id) {
        $this->solicitud->idSolicitud = $id;
        $result = $this->solicitud->getSolicitudById();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetch(PDO::FETCH_ASSOC));
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function getSolicitudesByCliente($idCliente) {
        $this->solicitud->idCliente = $idCliente;
        $result = $this->solicitud->getSolicitudesByCliente();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        } else {
            $response = [];
        }
        return $response;
    }
    private function getSolicitudesByEspecialista($idEspecialista) {
        $this->solicitud->idEspecialista = $idEspecialista;
        $result = $this->solicitud->getSolicitudesByEspecialista();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        } else {
            $response = [];
        }
        return $response;
    }

    private function getSolicitudesByServicio($idServicio) {
        $this->solicitud->idServicio = $idServicio;
        $result = $this->solicitud->getSolicitudesByServicio();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function createSolicitud() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validateSolicitud($input)) {
            return $this->unprocessableEntityResponse('Todos los campos son obligatorios');
        }

        $this->solicitud->idCliente = $input['idCliente'];
        $this->solicitud->idServicio = $input['idServicio'];
        $this->solicitud->descripcion = $input['descripcionServicio'];
        $this->solicitud->ubicacion = $input['direccion'];
        $this->solicitud->lat_long = $input['lat_long'];
        $this->solicitud->fechaHoraSolicitud = $input['fechaHoraSolicitud'];
        $this->solicitud->precio = $input['precio'];

        if ($this->solicitud->createSolicitud()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(['mensaje' => 'Solicitud registrada correctamente','estado' => 1]);
        } else {
            $response = $this->unprocessableEntityResponse('Error al registrar la solicitud');
        }

        return $response;
    }

    private function negociarSolicitud() {
        
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        $this->solicitud->idSolicitud = $input['idSolicitud'];
        $this->solicitud->idCliente = $input['idCliente'];
        $this->solicitud->idEspecialista = $input['idEspecialista'];
        $this->solicitud->precio = $input['precio'];

        if ($this->solicitud->negociarSolicitud()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(['mensaje' => 'Negociación enviada','estado' => 1]);
        } else {
            $response = $this->unprocessableEntityResponse('Error al neogociar');
        }

        return $response;
    }


    private function updateSolicitud($id) {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    
        $this->solicitud->idSolicitud = $id;
        $this->solicitud->descripcion = $input['descripcionServicio'];
        $this->solicitud->ubicacion = $input['direccion'];
        $this->solicitud->fechaHoraSolicitud = $input['fechaHoraSolicitud'];
        $this->solicitud->precio = $input['precio'];
        $this->solicitud->estado = isset($input['estado']) ? $input['estado'] : 1;
    
        if ($this->solicitud->updateSolicitud()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['mensaje' => 'Solicitud actualizada correctamente', 'estado' => 1]);
        } else {
            $response = $this->unprocessableEntityResponse('Error al actualizar la solicitud');
        }
    
        return $response;
    }

    private function updateSolicitudAceptada() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    

        $this->solicitud->idSolicitud = $input['idSolicitud'];
        $this->solicitud->idEspecialista = $input['idEspecialista'];
        $this->solicitud->precio = $input['precio'];
        $this->solicitud->estado = 2;
    
        if ($this->solicitud->updateSolicitudAceptada()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['mensaje' => 'Oferta aceptada', 'estado' => 1]);
        } else {
            $response = $this->unprocessableEntityResponse('Error al aceptar oferta');
        }
    
        return $response;
    }

    private function validateSolicitud($input) {
        return isset($input['idCliente'], $input['idServicio'], $input['descripcionServicio'], $input['direccion'], $input['fechaHoraSolicitud'], $input['precio']);
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
