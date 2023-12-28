<?php

    require_once '../../config/app.php';
    require_once '../../autoload.php';

    use app\controllers\usuarioController;
    $userController = new usuarioController(); 

    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(isset($_GET['rut'])){
                echo  json_encode($userController->ObtenerUsuariosAPI("rut",$_GET['rut']));
            }else if (isset($_GET['tipo'])){
                echo  json_encode($userController->ObtenerUsuariosAPI("tipo_usuario",$_GET['tipo']));
            }else if (isset($_GET['id_negocio'])){
                echo  json_encode($userController->ObtenerUsuariosAPI("negocio",$_GET['id_negocio']));
            }else if (isset($_GET['correo'])){
                echo  json_encode($userController->ObtenerUsuariosAPI("correo",$_GET['correo']));
            }else{
               echo json_encode($userController->ObtenerUsuariosAPI("todos",""));
            }
        case 'POST': 
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL){
                echo $userController->registrarUsuariosAPI($datos->rut,$datos->tipo,$datos->contrasena,$datos->correo,$datos->nombre,$datos->apellido,
                $datos->direccion,$datos->img_ruta,$datos->id_negocio);
                
            }else{
                http_response_code(405);
            }
            break;
        case 'PUT' :   
            $datos =json_decode(file_get_contents('php://input'));
            if($datos != NULL){
                echo $userController->actualizaUsuariosAPI($datos->rut,$datos->contrasena,$datos->nombre,$datos->apellido,
                $datos->direccion);
            }else{
                http_repsonse_code(405);
            }
            break;
        case 'DELETE' :
            if(isset($_GET['rut'])){
                echo $userController->eliminaUsuarioAPI($_GET['rut']);
            }else{
                http_response_code(405);
            }
            break;
        default:
        break;
    }
?>