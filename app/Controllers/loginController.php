<?php

namespace app\Controllers;

use app\Models\mainModel;
//use Firebase\JWT\JWT;
//use Firebase\JWT\Key;

class loginController extends mainModel{

    public function inicioSesionController(){

        $correo= $this->limpiarCadena($_POST["login_correo"]);
        $contrasena= $this->limpiarCadena($_POST["login_contrasena"]);
        if($correo == "" || $contrasena==""){
           echo "
           <script>
                Swal.fire({
                        icon:  'error',
                        title: 'Ha ocurrido un error',
                        text:  'No has completado todos los campos obligatorios',
                        confirmButtonText: 'Aceptar'
                    });
            </script>
           ";
        }else if(!filter_var($correo,FILTER_VALIDATE_EMAIL )) {
                echo "
                    <script>
                        Swal.fire({
                                icon:  'error',
                                title: 'Ha ocurrido un error',
                                text:  'El campo Correo no posee un formato valido',
                                confirmButtonText: 'Aceptar'
                            });
                    </script>
                    ";
        } else if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $contrasena)){
                echo "
                    <script>
                        Swal.fire({
                                icon:  'error',
                                title: 'Ha ocurrido un error',
                                text:  'El campo contraseña no posee un formato valido',
                                confirmButtonText: 'Aceptar'
                            });
                    </script>
                ";
        }
        $verficarUsuario = $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Correo = '$correo'");

        if($verficarUsuario->rowCount() == 1){
            
            $verficarUsuario = $verficarUsuario->fetch();
            if($verficarUsuario["Correo"] ==$correo && password_verify($contrasena,$verficarUsuario["Contrasena"]) ){
                
                
                $_SESSION['id_usuario'] = $verficarUsuario["Usuario_Dni"];
                $_SESSION['tipo_usuario'] = $verficarUsuario["Tipo"];
                $_SESSION['correo_usuario'] = $verficarUsuario["Correo"];
                $_SESSION['nombre_usuario'] = $verficarUsuario["Nombre"];
                $_SESSION['apellido_usuario'] = $verficarUsuario["Apellido"];
                $_SESSION['direccion_usuario'] = $verficarUsuario["Direccion"];
                $_SESSION['img_usuario'] = $verficarUsuario["img"];
                $_SESSION['id_negocio_usuario'] = $verficarUsuario["id_negocio"];
                $now = strtotime("now");
                $key = APP_SESSION_NAME;
                $payload = [
                    'exp' => $now +3600,
                    'data' => $verficarUsuario["Usuario_Dni"],
                ];
                /*$jwt = JWT::encode($payload, $key, 'HS256');
                $_SESSION['token'] = $jwt;
                if(headers_sent()){
                    echo "<script> 
                    localStorage.setItem('token', '".$jwt."');
                    window.location.href='".APP_URL."dashboard/'</script>";
                }else{
                    header("Location: ".APP_URL."dashboard/");
                }
                */
            }else{
                echo "
                    <script>
                        Swal.fire({
                                icon:  'error',
                                title: 'Ha ocurrido un error',
                                text:  'Correo o contraseña incorrectos',
                                confirmButtonText: 'Aceptar'
                            });
                    </script>
                ";
            }

        }else{
            echo "
                <script>
                    Swal.fire({
                            icon:  'error',
                            title: 'Ha ocurrido un error',
                            text:  'Correo o contraseña incorrectos',
                            confirmButtonText: 'Aceptar'
                        });
                </script>
            ";
        }
    }

    public function cerrarSesionController() {
    
        session_destroy();
        if(header_sent()){
            echo "<script> window.location.href='".APP_URL."login/';</script>";
        }else{
            header("Location: ".APP_URL."login/");
        }
    }
}
