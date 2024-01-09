<?php

namespace app\Controllers;

use app\Models\mainModel;


class usuarioController extends mainModel{

    #registro usuario
    public function registrarUsuarioController() {
    
        #guardardatos
        $rut= $this->limpiarCadena($_POST["usuario_RUT"]);
        $nombre= $this->limpiarCadena($_POST["usuario_nombre"]);
        $apellido= $this->limpiarCadena($_POST["usuario_apellido"]);
        $tipo= $this->limpiarCadena($_POST["usuario_tipo"]);
        $correo= $this->limpiarCadena($_POST["usuario_email"]);
        $direccion= $this->limpiarCadena($_POST["direccion"]);
        $contrasena1= $this->limpiarCadena($_POST["usuario_clave_1"]);
        $contrasena2= $this->limpiarCadena($_POST["usuario_clave_2"]);

        if($rut == "" || $direccion == ""||  $nombre == "" || $apellido == "" || $tipo == "" ||  $correo == "" || $contrasena1  == "" || $contrasena2== ""){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "No has completado todos los campos obligatorios",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo nombre no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo apellido no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("[1-4]", $tipo)){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo tipo no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $direccion)){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "La Direccion no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $contrasena1) ||  $this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $contrasena2) ){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "Las contraseñas no poseen el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        /*
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $rut) ){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo RUT no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        */
        if($correo != ""){
            if(filter_var($correo,FILTER_VALIDATE_EMAIL )){
                $verficarCorreo = $this->ejecutarConsulta("SELECT Correo FROM t_usuario WHERE Correo = '$correo'");

                if($verficarCorreo->rowCount() >0 ){
                    $alerta= [
                        "tipo" => "simple",
                        "titulo" =>"Ha ocurrido un error",
                        "texto" => "El  Correo ingresado ya existe en el sistema",
                        "icono" => "error",
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }else{
                $alerta= [
                    "tipo" => "simple",
                    "titulo" =>"Ha ocurrido un error",
                    "texto" => "El campo Correo no posee un formato valido",
                    "icono" => "error",
                ];
                return json_encode($alerta);
                exit();
            }
        }

        if($contrasena1 != $contrasena2 ){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "las contraseñas no coinciden",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }else{
            $contrasena = password_hash($contrasena1,PASSWORD_BCRYPT,["cost"=>10]);
        }

        $verficarRut = $this->ejecutarConsulta("SELECT Usuario_Dni  FROM t_usuario WHERE Usuario_Dni  = '$rut'");
        if($verficarRut->rowCount() >0 ){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El  usuario ingresado ya existe en el sistema",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }

        $img_dir= "../views/fotos/";

        if($_FILES["usuario_foto"]["name"] != "" && $_FILES["usuario_foto"]["size"] >0 ){

            if(!file_exists($img_dir)){
                if(!mkdir($img_dir,0777)){
                    $alerta= [
                        "tipo" => "simple",
                        "titulo" =>"Ha ocurrido un error",
                        "texto" => "Error al crear directorio",
                        "icono" => "error",
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }
            if(mime_content_type($_FILES["usuario_foto"]["tmp_name"]) != "image/jpeg" && mime_content_type($_FILES["usuario_foto"]["tmp_name"]) != "image/png" ){
                $alerta= [
                    "tipo" => "simple",
                    "titulo" =>"Ha ocurrido un error",
                    "texto" => "Formato incorrecto de imagen",
                    "icono" => "error",
                ];
                return json_encode($alerta);
                exit();
            }
            if($_FILES["usuario_foto"]["size"]/1024 > 5120 ){
                $alerta= [
                    "tipo" => "simple",
                    "titulo" =>"Ha ocurrido un error",
                    "texto" => "El peso de la imgaen es mayor al permitido",
                    "icono" => "error",
                ];
                return json_encode($alerta);
                exit();
            }
            $foto = str_replace(" ", "_" ,$nombre);
            $foto = $foto."_".rand(0,100);

            switch (mime_content_type($_FILES["usuario_foto"]["tmp_name"])) {
                case 'image/jpeg':
                    $foto = $foto.".jpg";
                    break;
                case 'image/png':
                    $foto = $foto.".png";
                    break;
            }
            chmod($img_dir,0777);
            if(!move_uploaded_file($_FILES["usuario_foto"]["tmp_name"],$img_dir,$foto)){
                $alerta= [
                    "tipo" => "simple",
                    "titulo" =>"Ha ocurrido un error",
                    "texto" => "no se ha podido subir la imagen en este momento",
                    "icono" => "error",
                ];
                return json_encode($alerta);
                exit();
            }
        }else{
            $foto ="";
        }

        $usuario_datos_reg= [
            [
                "campo_nombre" => "Usuario_Dni ",
                "campo_marcador" => ":rut",
                "campo_valor" => $rut,

            ],
            [
                "campo_nombre" => "Nombre",
                "campo_marcador" => ":nombre",
                "campo_valor" => $nombre,
            ],
            [
                "campo_nombre" => "Apellido",
                "campo_marcador" => ":apellido",
                "campo_valor" => $apellido,
            ],
            [
                "campo_nombre" => "Correo",
                "campo_marcador" => ":correo",
                "campo_valor" => $correo,
            ],
            [
                "campo_nombre" => "Tipo",
                "campo_marcador" => ":tipo",
                "campo_valor" => $tipo,
            ],
            [
                "campo_nombre" => "Contrasena",
                "campo_marcador" => ":contrasena",
                "campo_valor" => $contrasena,
            ],
            [
                "campo_nombre" => "Direccion",
                "campo_marcador" => ":direccion",
                "campo_valor" => $direccion,
            ],
            [
                "campo_nombre" => "img",
                "campo_marcador" => ":img",
                "campo_valor" => $foto,
            ]
        ];
      
        $registrarUsuario = $this->guardarDatos("t_usuario",$usuario_datos_reg);
        
        if($registrarUsuario->rowCount() ==1 ){
            $alerta= [
                "tipo" => "limpiar",
                "titulo" =>"Usuario Registrado",
                "texto" => "El usuario ". $nombre ." ". $apellido. " ha sido registrado correctamente",
                "icono" => "success",
            ];
            return json_encode($alerta);
            exit();
        }else{

            if(is_file($img_dir.$foto)){

                chmod($img_dir,0777);
                unlink($img_dir.$foto);
            }

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "No se pudo registrar",
                "icono" => "error",
            ];
        }
    }

    public function listarUsuarioController($pagina,$registros,$url,$busqueda){
        
        $pagina= $this->limpiarCadena($pagina);
        $registros= $this->limpiarCadena($registros);
        $pagina= $this->limpiarCadena($url);
      
        $url =APP_URL.$url."/";

        $busqueda= $this->limpiarCadena($busqueda);
        $tabla ="";

        $pagina = (isset($pagina) && $pagina> 0) ? (int) $pagina : 1;

        $inicio = ($pagina> 0) ? (($pagina*$registros)-$registros) : 0 ;

        if(isset($busqueda) && $busqueda != "") {

            $consulta_datos ="SELECT * FROM t_usuario WHERE ((Usuario_Dni != '".$_SESSION["id_usuario"]."' AND Tipo !=3 OR Tipo !=2) AND (Nombre LIKE '%$busqueda%' OR Apellido LIKE '%$busqueda%' OR Correo LIKE '%$busqueda%' OR Tipo LIKE '%$busqueda%')) LIMIT $inicio ,$registros";

            $consulta_total ="SELECT COUNT(Usuario_Dni) FROM t_usuario WHERE ((Usuario_Dni != '".$_SESSION["id_usuario"]."' AND Tipo !=3 OR Tipo !=2) AND (Nombre LIKE '%$busqueda%' OR Apellido LIKE '%$busqueda%' OR Correo LIKE '%$busqueda%' OR Tipo LIKE '%$busqueda%'))";

        }else{
            $consulta_datos ="SELECT * FROM t_usuario WHERE Usuario_Dni = '".$_SESSION["id_usuario"]."' AND Tipo !=3 OR Tipo !=2 LIMIT $inicio ,$registros";

            $consulta_total ="SELECT COUNT(Usuario_Dni) FROM t_usuario WHERE Usuario_Dni = '".$_SESSION["id_usuario"]."' AND Tipo !=3";
        }

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total/$registros);

        $tabla .= '	<div class="table-container">
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <thead>
                                <tr>
                                    <th class="has-text-centered">#</th>
                                    <th class="has-text-centered">Nombre</th>
                                    <th class="has-text-centered">Usuario</th>
                                    <th class="has-text-centered">Email</th>
                                    <th class="has-text-centered" colspan="3">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            ';

        if($total>=1 && $pagina<=$numeroPaginas){
            $contador=$inicio+1;
            $pag_inicio=$inicio+1;
            foreach($datos as $fila){
                $tabla.='
                        <tr class="has-text-centered" >
                        <td>'.$contador.'</td>
                        <td>'.$fila['Nombre'].' '.$fila['Apellido'].'</td>
                        <td>'.$fila['Usuario_Dni'].'</td>
                        <td>'.$fila['Correo'].'</td>
                        <td>
                            <a href="'.APP_URL.'fotoUsuario/'.$fila['Usuario_Dni'].'/" class="button is-info is-rounded is-small">Foto</a>
                        </td>
                        <td>
                            <a href="'.APP_URL.'actualizarUsuario/'.$fila['Usuario_Dni'].'/" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

                                <input type="hidden" name="modulo_usuario" value="eliminar">
                                <input type="hidden" name="usuario_id" value="'.$fila['Usuario_Dni'].'">

                                <button type="submit" class="button is-danger is-rounded is-small">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                ';
                $contador++;
            }
            $pag_final=$contador-1;
        }else{
            if($total>=1){
                $tabla.='
                <tr class="has-text-centered" >
                                <td colspan="7">
                                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
                                        Haga clic acá para recargar el listado
                                    </a>
                                </td>
                            </tr>
                            ';
            }else{
                $tabla.='
                            <tr class="has-text-centered" >
                                <td colspan="7">
                                    No hay registros en el sistema
                                </td>
                            </tr>
                            ';
            }
        }

        $tabla.='</tbody></table></div>';                

        if($total>0 && $pagina<=$numeroPaginas){
            $tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
            if($pagina == 0 ){
                $pagina = 1 ;
            }
            $tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7); 
        }

        return $tabla;
    }

    public function eliminarUsuarioController(){

        $id= $this->limpiarCadena($_POST["usuario_id"]);

        if($id == 1){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "No podemos elimianr este usuario",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }

        $datos= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$id' ");

        if($datos->rowCount()<=0){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "No se encuentra el usuario seleccionado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }else{
            $datos=$datos->fetch();
        }
        $eliminarUsuario=$this->eliminarRegistro('t_usuario','Usuario_Dni',$id);

        if($eliminarUsuario->rowCount() == 1){
            if(is_file('../views/fotos/'.$datos["Nombre"])){

                chmod('../views/fotos/',0777);
                unlink('../views/fotos/'.$datos["Nombre"]);
            }
            $alerta= [
                "tipo" => "recargar",
                "titulo" =>"Usuario eliminado",
                "texto" => "El usuario".$datos["Nombre"]. " ".$datos["Apellido"]. " ha sido eliminado correctamente",
                "icono" => "success",
            ];
            return json_encode($alerta);
        }else{
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "No se pudo eliminar el usuario, ".$datos["Nombre"]. " ".$datos["Apellido"].  "intente nuevamente",
                "icono" => "error",
            ];

            return json_encode($alerta);
        }

    }

    public function actualizarUsuarioController(){

        $id= $this->limpiarCadena($_POST["usuario_id"]);

        $datos= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$id' ");
        if($datos->rowCount()<=0){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "No se encuentra el usuario seleccionado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }else{
            $datos=$datos->fetch();
        }
        $rut= $this->limpiarCadena($_POST["rut_usuario"]);
        $claveActual= $this->limpiarCadena($_POST["usuario_clave"]);

        if($rut ==""|| $claveActual == ""){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "No has completado todos los campos obligatorios",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $claveActual) ){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "Las contraseña actual no poseen el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        /*
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $rut) ){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "Las contraseña actual no poseen el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }*/

       
        //$verificarAdmin= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$id' AND Tipo = 3 OR Tipo=2 ");
        $verificarAdmin= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$id'");

        if($verificarAdmin->rowCount()==1){
            $verificarAdmin=$verificarAdmin->fetch();

            if($verificarAdmin["Usuario_Dni"] != $rut || !password_verify($claveActual, $verificarAdmin["Contrasena"]) ){
                $alerta= [
                    "tipo" => "simple",
                    "titulo" =>"Ha ocurrido un error inesperado",
                    "texto" => "rut o contraseña incorrecta",
                    "icono" => "error",
                ];
                return json_encode($alerta);
                exit();
            }
            
        }else{
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "No Posee los permisos para modificar el usuario seleccionado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }

     
        $nombre= $this->limpiarCadena($_POST["usuario_nombre"]);
        $apellido= $this->limpiarCadena($_POST["usuario_apellido"]);
        $direccion= $this->limpiarCadena($_POST["usuario_direccion"]);
        $contrasena1= $this->limpiarCadena($_POST["usuario_clave_1"]);
        $contrasena2= $this->limpiarCadena($_POST["usuario_clave_2"]);

        if($direccion == ""||  $nombre == "" || $apellido == ""){

            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No has llenado todos los campos que son obligatorios",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }
        
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El NOMBRE no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El APELLIDO no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }


        
        if($contrasena1 != "" || $contrasena2 != ""){
            if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $contrasena1) || $this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $contrasena2)){

                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>"Las CLAVES no coinciden con el formato solicitado",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();
            }else{
                if($contrasena1 !=$contrasena2){

                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"Las nuevas CLAVES que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }else{
                    $contrasena=password_hash($contrasena1,PASSWORD_BCRYPT,["cost"=>10]);
                }
            }
        }else{
            $contrasena=$datos["Contrasena"];
        }

        $usuario_datos_up=[
            [
                "campo_nombre"=>"Nombre",
                "campo_marcador"=>":nombre",
                "campo_valor"=>$nombre
            ],
            [
                "campo_nombre"=>"Apellido",
                "campo_marcador"=>":apellido",
                "campo_valor"=>$apellido
            ],
            [
                "campo_nombre"=>"Contrasena",
                "campo_marcador"=>":contrasena",
                "campo_valor"=>$contrasena
            ],
            [
                "campo_nombre" => "Direccion",
                "campo_marcador" => ":direccion",
                "campo_valor" => $direccion
            ]
        ];
        $condicion=[
            "condicion_campo" => "Usuario_Dni ",
            "condicion_marcador" => ":rut",
            "condicion_valor" => $rut
        ];
        if($this->actualizarDatos("t_usuario",$usuario_datos_up,$condicion)){

            if($id==$_SESSION["id_usuario"]){
                $_SESSION['nombre_usuario'] =$nombre ;
                $_SESSION['apellido_usuario'] =$apellido ;
                $_SESSION['direccion_usuario'] =$direccion ;
            }

            $alerta=[
                "tipo"=>"recargar",
                "titulo"=>"Usuario actualizado",
                "texto"=>"Los datos del usuario ".$datos['Nombre']." ".$datos['Apellido']." se actualizaron correctamente",
                "icono"=>"success"
            ];
        }else{
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No hemos podido actualizar los datos del usuario ".$datos['Nombre']." ".$datos['Apellido'].", por favor intente nuevamente",
                "icono"=>"error"
            ];
        }
    
        return json_encode($alerta);
    }

    public function ObtenerUsuariosAPI($tipo,$valor){
      
        if($valor == ""){
            $consulta_datos ="SELECT * FROM t_usuario LIMIT 200";
        }else if($tipo == "negocio"){
            $consulta_datos =" SELECT * FROM t_usuario WHERE id_negocio = $valor";
        }elseif ($tipo == "rut"){
            $consulta_datos = "SELECT * FROM t_usuario WHERE Usuario_Dni = $valor";
        }elseif ($tipo == "correo"){
            $consulta_datos = "SELECT * FROM t_usuario WHERE Correo = $valor";
        }else{
            $consulta_datos = "SELECT * FROM t_usuario WHERE Tipo = $valor";
        }
        $resultado = $this->ejecutarConsulta($consulta_datos);
        $datos=[];
        $resultado = $resultado->fetchAll();
        foreach($resultado as $fila){
            $datos[] = [
                'id_usuario'=>$fila["Usuario_Dni"],
                'tipo'=>$fila["Tipo"],
                'contrasena' => $fila["Contrasena"],
                'nombre'=>$fila["Nombre"],
                'Apellido'=>$fila["Apellido"],
                'direccion'=>$fila["Direccion"],
                'img_ruta' => $fila["img"],
                'rating' => $fila["Ranking"],
                'id_negocio' => $fila["id_negocio"]
            ];
        }
        return $datos;
    }
    public function registrarUsuariosAPI($rut,$tipo,$contrasena,$correo,$nombre,$apellido, $direccion,$img_ruta,$id_negocio ){
        
        $rut= $this->limpiarCadena($rut);
        $nombre= $this->limpiarCadena($nombre);
        $apellido= $this->limpiarCadena($apellido);
        $tipo= $this->limpiarCadena($tipo);
        $correo= $this->limpiarCadena($correo);
        $direccion= $this->limpiarCadena($direccion);
        $contrasena= $this->limpiarCadena($contrasena);
        $id_negocio= $this->limpiarCadena($id_negocio);
        $img_ruta= $this->limpiarCadena($img_ruta);

        if($rut == "" || $direccion == ""||  $nombre == "" || $apellido == "" || $tipo == "" ||  $correo == "" || $contrasena == ""){

            return ("No has completado todos los campos obligatorios");
            exit();
        }

        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){

            return ("El campo nombre no posee el formato solicitado");
            exit();
        }
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){

            return ("El campo apellido no posee el formato solicitado");
            exit();
        }
        if($this->verificarDatos("[1-4]", $tipo)){

            return ("El campo tipo no posee el formato solicitado");
            exit();
        }
        /*if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $direccion)){

            return ("La Direccion no posee el formato solicitado");
            exit();
        }*/
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $contrasena)){


            return ("Las contraseña no poseen el formato solicitado");
            exit();
        }

        if($correo != ""){
            if(filter_var($correo,FILTER_VALIDATE_EMAIL )){
                $verficarCorreo = $this->ejecutarConsulta("SELECT Correo FROM t_usuario WHERE Correo = '$correo'");

                if($verficarCorreo->rowCount() >0 ){
                    return ("El  Correo ingresado ya existe en el sistema");
                    exit();
                }
            }else{
                return ("El campo Correo no posee un formato valido");
                exit();
            }
        }

        $verficarRut = $this->ejecutarConsulta("SELECT Usuario_Dni  FROM t_usuario WHERE Usuario_Dni  = '$rut'");
        if($verficarRut->rowCount() >0 ){

            return ("El usuario ingresado ya existe en el sistema");
            exit();
        }

        $contrasena = password_hash($contrasena,PASSWORD_BCRYPT,["cost"=>10]);
        $usuario_datos_reg= [
            [
                "campo_nombre" => "Usuario_Dni ",
                "campo_marcador" => ":rut",
                "campo_valor" => $rut,

            ],
            [
                "campo_nombre" => "Nombre",
                "campo_marcador" => ":nombre",
                "campo_valor" => $nombre,
            ],
            [
                "campo_nombre" => "Apellido",
                "campo_marcador" => ":apellido",
                "campo_valor" => $apellido,
            ],
            [
                "campo_nombre" => "Correo",
                "campo_marcador" => ":correo",
                "campo_valor" => $correo,
            ],
            [
                "campo_nombre" => "Tipo",
                "campo_marcador" => ":tipo",
                "campo_valor" => $tipo,
            ],
            [
                "campo_nombre" => "Contrasena",
                "campo_marcador" => ":contrasena",
                "campo_valor" => $contrasena,
            ],
            [
                "campo_nombre" => "Direccion",
                "campo_marcador" => ":direccion",
                "campo_valor" => $direccion,
            ],
            [
                "campo_nombre" => "img",
                "campo_marcador" => ":img",
                "campo_valor" => $img_ruta,
            ]
        ];
      
        $registrarUsuario = $this->guardarDatos("t_usuario",$usuario_datos_reg);
        
        if($registrarUsuario->rowCount() ==1 ){
            return ("El usuario ". $nombre ." ". $apellido. " ha sido registrado correctamente");
            exit();
        }else{
            return ("No se pudo registrar");
            exit();
        }
    }
    public function actualizaUsuariosAPI($rut,$contrasena,$nombre,$apellido,$direccion){

        
        $rut= $this->limpiarCadena($rut);
        $contrasena= $this->limpiarCadena($contrasena);

        $datos= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$rut' ");
        if($datos->rowCount()<=0){
            return ("No se encuentra el usuario seleccionado");
            exit();
        }else{
            $datos=$datos->fetch();
        }
        if($rut == ""){
            return ("No se encuentra el usuario seleccionado");
            exit();
        }

    
        //$verificarAdmin= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$id' AND Tipo = 3 OR Tipo=2 ");
     
        $nombre= $this->limpiarCadena($nombre);
        $apellido= $this->limpiarCadena($apellido);
        $direccion= $this->limpiarCadena($direccion);
 

        if($direccion == ""||  $nombre == "" || $apellido == ""){
            return ("No has llenado todos los campos que son obligatorios");
            exit();
        }
        
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $contrasena) ){

            return ("La contraseña no poseen el formato solicitado");
            exit();
        } 

        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){

            return ("La nombre no poseen el formato solicitado");
            exit();
        }
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
            return ("La apellido no poseen el formato solicitado");
            exit();
        }

        $contrasena=password_hash($contrasena,PASSWORD_BCRYPT,["cost"=>10]);

        $usuario_datos_up=[
            [
                "campo_nombre"=>"Nombre",
                "campo_marcador"=>":nombre",
                "campo_valor"=>$nombre
            ],
            [
                "campo_nombre"=>"Apellido",
                "campo_marcador"=>":apellido",
                "campo_valor"=>$apellido
            ],
            [
                "campo_nombre"=>"Contrasena",
                "campo_marcador"=>":contrasena",
                "campo_valor"=>$contrasena
            ],
            [
                "campo_nombre" => "Direccion",
                "campo_marcador" => ":direccion",
                "campo_valor" => $direccion
            ]
        ];
        $condicion=[
            "condicion_campo" => "Usuario_Dni ",
            "condicion_marcador" => ":rut",
            "condicion_valor" => $rut
        ];
        if($this->actualizarDatos("t_usuario",$usuario_datos_up,$condicion)){

            return ("Los datos  se han actualizado correctamente");
            exit();
        }else{
            return ("Los datos no se han actualizado correctamente intente mas tarde");
            exit();
        }


    }

    Public function eliminaUsuarioAPI($rut){
        $id= $this->limpiarCadena($rut);

        if($id == 1){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "",
                "icono" => "error",
            ];
            return "No podemos elimianr este usuario";
            exit();
        }

        $datos= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$id' ");

        if($datos->rowCount()<=0){

            return "No se encuentra el usuario seleccionado";
            exit();
        }else{
            $datos=$datos->fetch();
        }
        $eliminarUsuario=$this->eliminarRegistro('t_usuario','Usuario_Dni',$id);

        if($eliminarUsuario->rowCount() == 1){
            if(is_file('../views/fotos/'.$datos["Nombre"])){

                chmod('../views/fotos/',0777);
                unlink('../views/fotos/'.$datos["Nombre"]);
            }
            return "El usuario ".$datos["Nombre"]. " ".$datos["Apellido"]. " ha sido eliminado correctamente";
            exit();
        }else{
            return "No se pudo eliminar el usuario, ".$datos["Nombre"]. " ".$datos["Apellido"].  "intente nuevamente";
            exit();
        }
    }
    /*----------  Controlador eliminar foto usuario  ----------*/
}
