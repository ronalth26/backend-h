<?php
require './config/Database.php';
require './controllers/UsuariosController.php';
require './controllers/CategoriasController.php';
require './controllers/ServiciosController.php';
require './controllers/SolicitudesController.php';
require './controllers/ValoracionesController.php';
require './controllers/QuejasController.php';
require './controllers/PublicacionController.php';

// Configurar encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Manejo de solicitudes OPTIONS preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}


$database = new Database();
$db = $database->getConnection();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Verificar si existe el parámetro 'controller' en la solicitud
if (isset($_GET['controller'])) {
    if ($_GET['controller'] === 'usuarios') {
        $userId = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;
        $controller = new UsuariosController($db, $requestMethod, $userId);
        $controller->processRequest();
    } elseif ($_GET['controller'] === 'categorias') {
        $categoriaId = isset($_GET['idCategoria']) ? $_GET['idCategoria'] : null;
        $controller = new CategoriasController($db, $requestMethod, $categoriaId);
        $controller->processRequest();
    } elseif ($_GET['controller'] === 'servicios') {
        $servicioId = isset($_GET['idServicio']) ? $_GET['idServicio'] : null;
        $categoriaId = isset($_GET['idCategoria']) ? $_GET['idCategoria'] : null;
        $controller = new ServiciosController($db, $requestMethod, $servicioId, $categoriaId);
        $controller->processRequest();
    } elseif ($_GET['controller'] === 'solicitudes') {
        $solicitudId = isset($_GET['idSolicitud']) ? $_GET['idSolicitud'] : null;
        $clienteId = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;
        $especialistaId = isset($_GET['idEspecialista']) ? $_GET['idEspecialista'] : null;
        $servicioId = isset($_GET['idServicio']) ? $_GET['idServicio'] : null;
        $negociaciones = isset($_GET['negociaciones']) ? $_GET['negociaciones'] : null;
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $controller = new SolicitudesController($db, $requestMethod, $solicitudId, $clienteId, $especialistaId, $servicioId, $negociaciones, $action);
        $controller->processRequest();
    } elseif ($_GET['controller'] === 'valoraciones') {
        $idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;
        $idEspecialista = isset($_GET['idEspecialista']) ? $_GET['idEspecialista'] : null;
        $solicitudId = isset($_GET['solicitudId']) ? $_GET['solicitudId'] : null;
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $controller = new ValoracionesController($db, $requestMethod, $solicitudId, null, null, null, null, $idCliente, $idEspecialista, $action);
        $controller->processRequest();
    } elseif ($_GET['controller'] === 'quejas') {
        $quejaId = isset($_GET['idQueja']) ? $_GET['idQueja'] : null;
        $controller = new QuejasController($db, $requestMethod, $quejaId);
        $controller->processRequest();
    } elseif ($_GET['controller'] === 'publicaciones') {
        $publicacionId = isset($_GET['idPublicacion']) ? $_GET['idPublicacion'] : null;
        $controller = new PublicacionController($db, $requestMethod, $publicacionId);
        $controller->processRequest();
    } else {
        header("HTTP/1.1 404 Not Found");
        echo json_encode([
            'mensaje' => 'Ruta no encontrada.'
        ]);
        exit();
    }
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode([
        'mensaje' => 'Ruta no encontrada.'
    ]);
    exit();
}
