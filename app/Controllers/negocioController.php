<?php

namespace app\Controllers;

use app\models\mainModel;


class negocioController extends mainModel{



    public function registrarNegocioController() {
    
        #guardardatos
        $rut= $this->limpiarCadena($_POST["negocio_rut"]);
        $numero_cuenta= $this->limpiarCadena($_POST["negocio_numero_cuenta"]);
        $nombre= $this->limpiarCadena($_POST["negocio_nombre"]);
        $representante_legal= $this->limpiarCadena($_POST["negocio_nombre_representante"]);
        $razon_social= $this->limpiarCadena($_POST["negocio_razon_social"]);
        $tipo= $this->limpiarCadena($_POST["negocio_tipo"]);
        $giro= $this->limpiarCadena($_POST["negocio_giro"]);
        $giro = 960200;
        $dependientes= $this->limpiarCadena($_POST["negocio_dependientes"]);
        $direccion= $this->limpiarCadena($_POST["negocio_direccion"]);

        if($rut == "" || $numero_cuenta == ""||  $nombre == "" || $representante_legal == "" || $razon_social == "" ||  $tipo == "" || $giro  == "" || $direccion== ""){

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
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $dependientes)){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo Dependientes no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $razon_social)){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo Razón Social no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $representante_legal)){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo Nombre representante legal no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        if($this->verificarDatos("[1-20]", $tipo)){

            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El campo tipo no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        /*
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $direccion)){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "La Direccion no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }else{
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($direccion).'&sensor=false');          
            $geo = json_decode($geo, true);
            if ($geo['status'] = 'OK') {
                // Obtener los valores
                $latitud = $geo['results'][0]['geometry']['location']['lat'];
                $longitud = $geo['results'][0]['geometry']['location']['lng'];
            }
        }
        
        if($this->verificarDatos("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $numero_cuenta)){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "La Direccion no posee el formato solicitado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }

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
        
        $verficarGiro = $this->ejecutarConsulta("SELECT Nombre  FROM t_giro WHERE Giro_Codigo  = '$giro'");
        if($verficarGiro->rowCount() == 0 ){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error",
                "texto" => "El  giro ingresado no existe",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }
        
        */
        //borrar
        $latitud = 0;
        $longitud = 0;
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

        if($_FILES["negocio_foto"]["name"] != "" && $_FILES["negocio_foto"]["size"] >0 ){

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
            if(mime_content_type($_FILES["negocio_foto"]["tmp_name"]) != "image/jpeg" && mime_content_type($_FILES["negocio_foto"]["tmp_name"]) != "image/png" ){
                $alerta= [
                    "tipo" => "simple",
                    "titulo" =>"Ha ocurrido un error",
                    "texto" => "Formato incorrecto de imagen",
                    "icono" => "error",
                ];
                return json_encode($alerta);
                exit();
            }
            if($_FILES["negocio_foto"]["size"]/1024 > 5120 ){
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

            switch (mime_content_type($_FILES["negocio_foto"]["tmp_name"])) {
                case 'image/jpeg':
                    $foto = $foto.".jpg";
                    break;
                case 'image/png':
                    $foto = $foto.".png";
                    break;
            }
            chmod($img_dir,0777);
            if(!move_uploaded_file($_FILES["negocio_foto"]["tmp_name"],$img_dir,$foto)){
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
        $negocio_datos_reg= [
            [
                "campo_nombre" => "Negocio_Dni",
                "campo_marcador" => ":rut",
                "campo_valor" => $rut,

            ],
            [
                "campo_nombre" => "Numero_Cuenta",
                "campo_marcador" => ":numeroCuenta",
                "campo_valor" => $numero_cuenta,
            ],
            [
                "campo_nombre" => "Nombre_Negocio",
                "campo_marcador" => ":nombre",
                "campo_valor" => $nombre,
            ],
            [
                "campo_nombre" => "Nombre_Representante_Legal",
                "campo_marcador" => ":nombreRepresentante",
                "campo_valor" => $representante_legal,
            ],
            [
                "campo_nombre" => "Razon_Social",
                "campo_marcador" => ":razon",
                "campo_valor" => $razon_social,
            ],
            [
                "campo_nombre" => "Tipo_Negocio",
                "campo_marcador" => ":tipo",
                "campo_valor" => $tipo,
            ],
            [
                "campo_nombre" => "Direccion",
                "campo_marcador" => ":direccion",
                "campo_valor" => $direccion,
            ],
            [
                "campo_nombre" => "lat",
                "campo_marcador" => ":lat",
                "campo_valor" => $latitud,
            ],
            [
                "campo_nombre" => "lon",
                "campo_marcador" => ":lon",
                "campo_valor" => $longitud,
            ],
            [
                "campo_nombre" => "Imagen",
                "campo_marcador" => ":img",
                "campo_valor" => $foto,
            ],
            [
                "campo_nombre" => "Dependientes",
                "campo_marcador" => ":dependientes",
                "campo_valor" => $dependientes,
            ],
            [
                "campo_nombre" => "id_giro ",
                "campo_marcador" => ":giro",
                "campo_valor" => $giro,
            ]

        ];
    
        $registrarNegocio = $this->guardarDatos("t_negocio",$negocio_datos_reg);
        
        if($registrarNegocio->rowCount() ==1 ){
            $alerta= [
                "tipo" => "limpiar",
                "titulo" =>"Negocio Registrado",
                "texto" => "El negocio ". $nombre ." ha sido registrado correctamente",
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
    public function listarNegocioController($pagina,$registros,$url,$busqueda){
        
        $pagina= $this->limpiarCadena($pagina);
        $registros= $this->limpiarCadena($registros);
        $pagina= $this->limpiarCadena($url);
      
        $url =APP_URL.$url."/";

        $busqueda= $this->limpiarCadena($busqueda);
        $tabla ="";

        $pagina = (isset($pagina) && $pagina> 0) ? (int) $pagina : 1;

        $inicio = ($pagina> 0) ? (($pagina*$registros)-$registros) : 0 ;

        if(isset($busqueda) && $busqueda != "") {

            $consulta_datos ="SELECT * FROM t_negocio WHERE ((Nombre_Negocio LIKE '%$busqueda%'  OR Tipo_Negocio LIKE '%$busqueda%' OR Nombre_Representante_Legal LIKE '%$busqueda%' OR Razon_Social LIKE '%$busqueda%' OR Direccion LIKE '%$busqueda%')) LIMIT $inicio ,$registros";

            $consulta_total ="SELECT COUNT(Negocio_Dni ) FROM t_negocio WHERE ((Nombre_Negocio LIKE '%$busqueda%' OR Tipo_Negocio LIKE '%$busqueda%' OR Nombre_Representante_Legal LIKE '%$busqueda%' OR Razon_Social LIKE '%$busqueda%' OR Direccion LIKE '%$busqueda%'))";

        }else{
            $consulta_datos ="SELECT * FROM t_negocio  LIMIT $inicio ,$registros";

            $consulta_total ="SELECT COUNT(Negocio_Dni ) FROM t_negocio ";
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
                                    <th class="has-text-centered">Negocio Dni</th>
                                    <th class="has-text-centered">Numero Cuenta</th>
                                    <th class="has-text-centered">Nombre Negocio</th>
                                    <th class="has-text-centered">Nombre Representante Legal</th>
                                    <th class="has-text-centered">Razon Social</th>
                                    <th class="has-text-centered">Tipo</th>
                                    <th class="has-text-centered">Direccion</th>
                                    <th class="has-text-centered">Giro</th>
                          
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
                        <td>'.$fila['Negocio_Dni'].'</td>
                        <td>'.$fila['Numero_Cuenta'].'</td>
                        <td>'.$fila['Nombre_Negocio'].'</td>
                        <td>'.$fila['Nombre_Representante_Legal'].'</td>
                        <td>'.$fila['Razon_Social'].'</td>
                        <td>'.$fila['Tipo_Negocio'].'</td>
                        <td>'.$fila['Direccion'].'</td>
                        <td>'.$fila['id_giro'].'</td>
                        <td>
                            <a href="'.APP_URL.'fotoNegocio/'.$fila['Negocio_Dni'].'/" class="button is-info is-rounded is-small">Foto</a>
                        </td>
                        <td>
                            <a href="'.APP_URL.'actualizarNegocio/'.$fila['Negocio_Dni'].'/" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="'.APP_URL.'app/ajax/NegocioAjax.php" method="POST" autocomplete="off" >

                                <input type="hidden" name="modulo_Negocio" value="eliminar">
                                <input type="hidden" name="Negocio_id" value="'.$fila['Negocio_Dni'].'">

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
            $tabla.='<p class="has-text-right">Mostrando Negocios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
            if($pagina == 0 ){
                $pagina = 1 ;
            }
            $tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7); 
        }

        return $tabla;
    }
    public function actualizarNegocioController(){

        $id_negocio= $this->limpiarCadena($_POST["negocio_id"]);
        $id_usuario= $this->limpiarCadena($_POST["usuario_id"]);

        $datos= $this->ejecutarConsulta("SELECT * FROM t_negocio WHERE Negocio_Dni = '$id_negocio'");
        if($datos->rowCount()<=0){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "No se encuentra el negocio seleccionado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
        }else{
            $datos=$datos->fetch();
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
        $verificarAdmin= $this->ejecutarConsulta("SELECT * FROM t_usuario WHERE Usuario_Dni = '$id_usuario'");

        if($verificarAdmin->rowCount()!=1){
            $alerta= [
                "tipo" => "simple",
                "titulo" =>"Ha ocurrido un error inesperado",
                "texto" => "No Posee los permisos para modificar el usuario seleccionado",
                "icono" => "error",
            ];
            return json_encode($alerta);
            exit();
            
        }
        $numero_cuenta= $this->limpiarCadena($_POST["negocio_numero_cuenta"]);
        $nombre_representante= $this->limpiarCadena($_POST["negocio_nombre_representante_legal"]);
        $direccion= $this->limpiarCadena($_POST["negocio_direccion"]);
        $razon_Social= $this->limpiarCadena($_POST["negocio_razon_Social"]);
        $dependientes= $this->limpiarCadena($_POST["negocio_dependientes"]);
        $giro= $this->limpiarCadena($_POST["negocio_giro"]);

        if($giro == ""||  $dependientes == "" || $razon_Social == ""|| $direccion == "" || $nombre_representante == "" || $numero_cuenta == ""){

            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No has llenado todos los campos que son obligatorios",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }
        /*
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
        */

        $negocio_datos_up=[
            [
                "campo_nombre"=>"Nombre_Representante_Legal",
                "campo_marcador"=>":nombre_representante",
                "campo_valor"=>$nombre_representante
            ],
            [
                "campo_nombre"=>"Numero_Cuenta",
                "campo_marcador"=>":numero_Cuenta",
                "campo_valor"=>$numero_cuenta
            ],
            [
                "campo_nombre"=>"Razon_Social",
                "campo_marcador"=>":Razon_Social",
                "campo_valor"=>$razon_Social
            ],
            [
                "campo_nombre" => "Direccion",
                "campo_marcador" => ":direccion",
                "campo_valor" => $direccion
            ],
            [
                "campo_nombre" => "Dependientes",
                "campo_marcador" => ":dependiente",
                "campo_valor" => $dependientes
            ],
            [
                "campo_nombre" => "Dependientes",
                "campo_marcador" => ":dependiente",
                "campo_valor" => $dependientes
            ],
            [
                "campo_nombre" => "id_giro",
                "campo_marcador" => ":giro",
                "campo_valor" => $giro
            ]
        ];
        $condicion=[
            "condicion_campo" => "Negocio_Dni ",
            "condicion_marcador" => ":NegocioDni",
            "condicion_valor" => $id_negocio
        ];
        if($this->actualizarDatos("t_negocio",$negocio_datos_up,$condicion)){

            $alerta=[
                "tipo"=>"recargar",
                "titulo"=>"Usuario actualizado",
                "texto"=>"Los datos del negocio ".$_POST['nombre_negocio']." se actualizaron correctamente",
                "icono"=>"success"
            ];
        }else{
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"No hemos podido actualizar los datos del negocio ".$_POST['nombre_negocio'].", por favor intente nuevamente",
                "icono"=>"error"
            ];
        }
    
        return json_encode($alerta);
    }
}