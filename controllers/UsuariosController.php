<?php
include_once './config/Database.php';
include_once './models/User.php';

require 'vendor/autoload.php';
use \Firebase\JWT\JWT;



class UsuariosController {
    private $db;
    private $requestMethod;
    private $userId;

    private $user;

    public function __construct($db, $requestMethod, $userId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->user = new User($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                }
                break;
            case 'POST':
                if (isset($_GET['action']) && $_GET['action'] === 'login') {
                    $response = $this->loginUser();
                } else if((isset($_GET['action']) && $_GET['action'] === 'registro')) {
                    $response = $this->createUser();
                } else if((isset($_GET['action']) && $_GET['action'] === 'crear_especialista')) {
                    $response = $this->crearEspecialista();
                } else {

                }
                break;
            case 'PUT':
                $response = $this->updateUser($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
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

    private function getAllUsers() {
        $result = $this->user->getAllUsers();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        return $response;
    }

    private function getUser($id) {
        $this->user->id = $id;
        $result = $this->user->getUserById();
        if ($result->rowCount() > 0) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result->fetch(PDO::FETCH_ASSOC));
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    private function createUser() {

        $input = json_decode(file_get_contents('php://input'), true);

        if (is_null($input)) {
            // Error en la decodificación del JSON
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(['error' => 'Entrada JSON no válida']);
            return $response;
        }

        $this->user->nombre = $input['nombre'];
        $this->user->apellido = $input['apellido'];
        $this->user->telefono = $input['telefono'];
        $this->user->email = $input['email'];
        $this->user->contrasena = crypt($input['contrasena'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

        $emailExists = $this->user->checkEmailExists();
        if ($emailExists->rowCount() > 0) {
            $response = $this->unprocessableEntityResponse("El email ya fue registrado.");
        } else {
            if ($this->user->createUser()) {

                 // Send email
                 $destinatario = $input['email'];
                 $asunto = "Verificación de Email";
                 $headers = "From: Equipo@workitout.com\r\n"; 
                 $headers .= "Reply-To: $destinatario\r\n";
                 $headers .= "MIME-Version: 1.0\r\n";
                 $headers .= "Content-Type: text/html; charset=utf-8\r\n";
 
                 $mensaje = '
                 <html lang="en">
                 <head>
                     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                     <meta http-equiv="X-UA-Compatible" content="IE=edge">
                     <meta name="viewport" content="width=device-width, initial-scale=1.0">
                     <meta name="description" content="WORKITOUT.">
                     <meta name="keywords" content="">
                     <meta name="author" content=WORKITOUT"">
                     <link rel="icon" href="https://sancotti.com/api_workitout/img/logo.png" type="image/x-icon">
                     <link rel="shortcut icon" href="https://sancotti.com/api_workitout/img/logo.png" type="image/x-icon">
                     <title>VERIFICACIÓN DE CORREO</title>
                     <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
                     <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
                     <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
                     <style type="text/css">
                     body{
                         width: 650px;
                         font-family: work-Sans, sans-serif;
                         background-color: #f6f7fb;
                         display: block;
                     }
                     a{
                         text-decoration: none;
                     }
                     span {
                         font-size: 14px;
                     }
                     p {
                         font-size: 13px;
                         line-height: 1.7;
                         letter-spacing: 0.7px;
                         margin-top: 0;
                     }
                     .text-center{
                         text-align: center
                     }
                     </style>
                 </head>
                 <body style="margin: 30px auto;">
                     <table style="width: 100%">
                     <tbody>
                         <tr>
                         <td>
                             <table style="background-color: #f6f7fb; width: 100%">
                             <tbody>
                                 <tr>
                                 <td>
                                     <table style="width: 650px; margin: 0 auto; margin-bottom: 30px">
                                     <tbody>
                                         <tr>
                                         <td>
                                            <center>
                                            <img src="https://sancotti.com/api_workitout/img/logo.png" alt="">
                                            </center>
                                         </td>
                                         <td style="text-align: right; color:#999"><span></span></td>
                                         </tr>
                                     </tbody>
                                     </table>
                                     <table style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px">
                                     <tbody>
                                         <tr>
                                         <td style="padding: 30px"> 
                                             <p>Bienvenido a WorkitOut,</p>
                                             <p>Gracias por registrarte en la plataforma</p>
                                             <p style="margin-bottom: 0">Buena suerte! Saludos de todo el equipo.</p>
                                         </td>
                                         </tr>
                                     </tbody>
                                     </table>
                                     <table style="width: 650px; margin: 0 auto; margin-top: 30px">
                                     <tbody>       
                                         <tr style="text-align: center">
                                        
                                         </tr>
                                     </tbody>
                                     </table>
                                 </td>
                                 </tr>
                             </tbody>
                             </table>
                         </td>
                         </tr>
                     </tbody>
                     </table>
                 </body>
                 </html>
                 ';
 
                 // Send the email
                 if(mail($destinatario, $asunto, $mensaje, $headers)) {
                     // $response['mensaje'] .= ' Email enviado.';
                 } else {
                     // $response['mensaje'] .= ' No se pudo enviar el email.';
                 }

                $response['status_code_header'] = 'HTTP/1.1 201 Created';
                $response['body'] = json_encode([
                    'mensaje' => 'Usuario creado.',
                    'estado' =>1
                ]);
            } else {
                $response = $this->unprocessableEntityResponse("Error al crear el usuario.");
            }
        }

        return $response;
    }



    private function crearEspecialista() {

        $input = json_decode(file_get_contents('php://input'), true);



        $this->user->idUsuario = $_POST['idUsuario'];
        $this->user->fechaNacimiento = $_POST['fechaNacimiento'];
        $this->user->documentoIdentidad = $_POST['documentoIdentidad'];
        $this->user->especialidades = $_POST['especialidades'];

       ////////////////////////////////////
       // SUBIR LA FOTO DE INDENTIFICACIÓN
       ////////////////////////////////////

       if (!empty($_FILES['fotoIdentificacion'])) {
           $file = $_FILES['fotoIdentificacion'];
           $filename = 'identificacion_' . $_POST['idUsuario'] . '_' . basename($file['name']);
           $target_dir = 'especialistas/'.$_POST['idUsuario'].'/';
           $target_file = $target_dir . $filename;
       
           // Create the directory if it doesn't exist
           if (!file_exists($target_dir)) {
               mkdir($target_dir, 0777, true);
           }
       
           if (move_uploaded_file($file['tmp_name'], $target_file)) {
               $this->user->indentificacion = $target_file;
           } else {
               return $this->unprocessableEntityResponse('Error al subir la imagen');
           }
       } else {
         $this->user->indentificacion = "";
       }

       ////////////////////////////////////
       // SUBIR LA FOTO FRENTE DNI
       ////////////////////////////////////

       if (!empty($_FILES['fotoFrente'])) {
           $file = $_FILES['fotoFrente'];
           $filename = 'dni_frente_' . $_POST['idUsuario'] . '_' . basename($file['name']);
           $target_dir = 'especialistas/'.$_POST['idUsuario'].'/';
           $target_file = $target_dir . $filename;
       
           // Create the directory if it doesn't exist
           if (!file_exists($target_dir)) {
               mkdir($target_dir, 0777, true);
           }
       
           if (move_uploaded_file($file['tmp_name'], $target_file)) {
               $this->user->dni_frente = $target_file;
           } else {
               return $this->unprocessableEntityResponse('Error al subir la imagen');
           }
       } else {
         $this->user->dni_frente = "";
       }
    
       ////////////////////////////////////
       // SUBIR LA FOTO ATRAS DNI
       ////////////////////////////////////

       if (!empty($_FILES['fotoAtras'])) {
           $file = $_FILES['fotoAtras'];
           $filename = 'dni_atras_' . $_POST['idUsuario'] . '_' . basename($file['name']);
           $target_dir = 'especialistas/'.$_POST['idUsuario'].'/';
           $target_file = $target_dir . $filename;
       
           // Create the directory if it doesn't exist
           if (!file_exists($target_dir)) {
               mkdir($target_dir, 0777, true);
           }
       
           if (move_uploaded_file($file['tmp_name'], $target_file)) {
               $this->user->dni_atras = $target_file;
           } else {
               return $this->unprocessableEntityResponse('Error al subir la imagen');
           }
       } else {
         $this->user->dni_atras = "";
       }
       
    
    
       ///////////////////////////////////
       // SUBIR LA FOTO CONFIRMACION
       ////////////////////////////////////

       if (!empty($_FILES['fotoConfirmacion'])) {
        $file = $_FILES['fotoConfirmacion'];
        $filename = 'confirmacion_' . $_POST['idUsuario'] . '_' . basename($file['name']);
        $target_dir = 'especialistas/'.$_POST['idUsuario'].'/';
        $target_file = $target_dir . $filename;
    
        // Create the directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $this->user->confirmacion = $target_file;
        } else {
            return $this->unprocessableEntityResponse('Error al subir la imagen');
        }
    } else {
      $this->user->confirmacion = "";
    }

      ////////////////////////////////////
       // SUBIR ANTECENDENTES PENALES
       ////////////////////////////////////

       if (!empty($_FILES['antecedentesPenales'])) {
        $file = $_FILES['antecedentesPenales'];
        $filename = 'antecendentes_' . $_POST['idUsuario'] . '_' . basename($file['name']);
           $target_dir = 'especialistas/'.$_POST['idUsuario'].'/';
        $target_file = $target_dir . $filename;
    
        // Create the directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $this->user->antecedentes = $target_file;
        } else {
            return $this->unprocessableEntityResponse('Error al subir la imagen');
        }
    } else {
      $this->user->antecedentes = "";
    }


       ////////////////////////////////////
       // SUBIR EVIDENCIAS
       ////////////////////////////////////

       if (!empty($_FILES['evidencias'])) {
        $file = $_FILES['evidencias'];
        $filename = 'evidencias_' . $_POST['idUsuario'] . '_' . basename($file['name']);
        $target_dir = 'especialistas/'.$_POST['idUsuario'].'/';
        $target_file = $target_dir . $filename;
    
        // Create the directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $this->user->evidencias = $target_file;
        } else {
            return $this->unprocessableEntityResponse('Error al subir la imagen');
        }
    } else {
      $this->user->evidencias = "";
    }
 

 

 
        if ($this->user->crearEspecialista()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(['mensaje' => 'Especialista Creado Correctamente', 'estado' => 1]);
        } else {
            $response = $this->unprocessableEntityResponse('Error al registrar la user');
        }

        return $response;
    }

   
    private function loginUser() {
        $input = json_decode(file_get_contents('php://input'), true);
    
        if (is_null($input)) {
            // Error en la decodificación del JSON
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(['error' => 'Entrada JSON no válida']);
            return $response;
        }
    
        if (!isset($input['email']) || !isset($input['password'])) {
            // Campos necesarios no proporcionados
            $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
            $response['body'] = json_encode(['error' => 'Faltan campos necesarios']);
            return $response;
        }
    
        // Asignar valores a la clase usuario
        $this->user->email = $input['email'];
        $this->user->contrasena = crypt($input['password'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
    
        // Ejecutar el método loginUser del modelo de usuario
        $result = $this->user->loginUser();
    
        if ($result->rowCount() > 0) {

               $user = $result->fetch(PDO::FETCH_ASSOC);
               $key = "e8a9f7e3c4d6b5a7e1f2c3b4a5d6f7e8a9b0c1d2e3f4g5h6i7j8k9l0m1n2o3";  // Cambia esto por tu propia clave secreta
               $payload = array(
                   "iss" => "https://workitout-utp.netlify.app/",
                   "aud" => "https://workitout-utp.netlify.app/",
                   "iat" => time(),
                   "nbf" => time(),
                   "exp" => time() + (60 * 60),  // El token expira en 1 hora
                   "data" => array(
                       'estado' => 1,
                       'id' => $user['id'],
                       'nombre' => $user['nombre'],
                       'apellido' => $user['apellido'],
                       'email' => $user['email'],
                       'especialista' => $user['especialista'],
                       'token' => "9a8b7c6d5e4f3a2b1c9d8e7f6b5a4c3d2e1f0a9b8c7d6e5f4g3h2i1j0k9l8m7"
                   )
               );
               
               $jwt = JWT::encode($payload, $key, 'HS256');
         
            //    // Usuario encontrado
            //    $user = $result->fetch(PDO::FETCH_ASSOC);
            //    $response['status_code_header'] = 'HTTP/1.1 200 OK';
            //    $response['body'] = json_encode([
            //        'estado' => 1,
            //        'mensaje' => 'El usuario está registrado.',
            //        'id' => $user['id'],
            //        'nombre' => $user['nombre'],
            //        'apellido' => $user['apellido'],
            //        'email' => $user['email'],
            //        'especialista' => $user['especialista']
            //    ]);
               // Usuario encontrado
             
               $response['status_code_header'] = 'HTTP/1.1 200 OK';
               $response['body'] = json_encode(['estado'=>1,'mensaje' => 'El usuario está registrado.','token'=>$jwt]);


        } else {
            // Usuario no encontrado o datos incorrectos
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = json_encode(['error' => 'Datos incorrectos']);
        }
    
        return $response;
    }
    

    private function updateUser($id) {
        // $result = $this->user->getUserById($id);
        // if ($result->rowCount() == 0) {
        //     return $this->notFoundResponse();
        // }

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        // if (!$this->validateUser($input)) {
        //     return $this->unprocessableEntityResponse();
        // }

        $this->user->id = $id;
        $this->user->nombre = $input['nombre'];
        $this->user->apellido = $input['apellido'];
        $this->user->telefono = $input['telefono'];
        $this->user->email = $input['email'];
        $this->user->contrasena = $input['contrasena']; // Assuming password is already encrypted

        if ($this->user->updateUser()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode([
                'mensaje' => 'Usuario actualizado.','estado'=> 1
            ]);
        } else {
            $response = $this->unprocessableEntityResponse("Error al actualizar el usuario.");
        }

        return $response;
    }

    private function deleteUser($id) {
        $result = $this->user->getUserById($id);
        if ($result->rowCount() == 0) {
            return $this->notFoundResponse();
        }

        $this->user->id = $id;
        if ($this->user->deleteUser()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode([
                'mensaje' => 'Usuario eliminado.'
            ]);
        } else {
            $response = $this->unprocessableEntityResponse("Error al eliminar el usuario.");
        }

        return $response;
    }

    // private function validateUser($input, $isLogin = false) {
    //     if (!isset($input['email'])) {
    //         return false;
    //     }

    //     if ($isLogin) {
    //         if (!isset($input['contrasena'])) {
    //             return false;
    //         }
    //     } else {
    //         if (!isset($input['nombre']) || !isset($input['apellido']) || !isset($input['telefono']) || !isset($input['contrasena'])) {
    //             return false;
    //         }
    //     }

    //     return true;
    // }

    private function unprocessableEntityResponse($message = "Datos invalidos.") {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'mensaje' => $message
        ]);
        return $response;
    }

    private function notFoundResponse($message = "Recurso no encontrado.") {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'mensaje' => $message
        ]);
        return $response;
    }
}
?>
