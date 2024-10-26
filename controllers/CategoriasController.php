<?php
include_once './config/Database.php';
include_once './models/Categoria.php';

class CategoriasController {
    private $db;
    private $requestMethod;
    private $categoriaId;

    private $categoria;

    public function __construct($db, $requestMethod, $categoriaId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->categoriaId = $categoriaId;

        $this->categoria = new Categoria($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->categoriaId) {
                    $response = $this->getCategoria($this->categoriaId);
                } else {
                    $response = $this->getAllCategorias();
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

    private function getAllCategorias() {
        $result = $this->categoria->getAllCategorias();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        return $response;
    }

    private function getCategoria($id) {
        $this->categoria->idCategoria = $id;
        $result = $this->categoria->getCategoriaById();
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
