<?php

namespace app\Controllers;

use app\Models\mainModel;

class servicioController extends mainModel{

    public function registrarServicioController() {
     #guardardatos
     $nombre= $this->limpiarCadena($_POST["nombre"]);
     $id_tipo= $this->limpiarCadena($_POST["id_tipo"]);

     if($nombre == ""){

         $alerta= [
             "tipo" => "simple",
             "titulo" =>"Ha ocurrido un error",
             "texto" => "No has completado todos los campos obligatorios",
             "icono" => "error",
         ];
         return json_encode($alerta);
         exit();
     }
     /*
     if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){

         $alerta= [
             "tipo" => "simple",
             "titulo" =>"Ha ocurrido un error",
             "texto" => "El campo Dependientes no posee el formato solicitado",
             "icono" => "error",
         ];
         return json_encode($alerta);
         exit();
     }
     */

    
     $servicio_datos_reg= [
         [
             "campo_nombre" => "nombre_servicio",
             "campo_marcador" => ":nombre",
             "campo_valor" => $nombre,
         ],
         [
            "campo_nombre" => "id_tipo_servicio",
            "campo_marcador" => ":idtipo",
            "campo_valor" => $id_tipo,
        ]

     ];
 
     $registrarServicio = $this->guardarDatos("t_servicio",$servicio_datos_reg);
     
     if($registrarServicio->rowCount() ==1 ){
         $alerta= [
             "tipo" => "limpiar",
             "titulo" =>"Servicio Registrado",
             "texto" => "El servicio ". $nombre ." ha sido registrado correctamente",
             "icono" => "success",
         ];
         return json_encode($alerta);
         exit();
     }else{

         $alerta= [
             "tipo" => "simple",
             "titulo" =>"Ha ocurrido un error",
             "texto" => "No se pudo registrar",
             "icono" => "error",
         ];
     }
    }
    public function listarServicioController($pagina,$registros,$url,$busqueda){
     
     $pagina= $this->limpiarCadena($pagina);
     $registros= $this->limpiarCadena($registros);
     $pagina= $this->limpiarCadena($url);
   
     $url =APP_URL.$url."/";

     $busqueda= $this->limpiarCadena($busqueda);
     $tabla ="";

     $pagina = (isset($pagina) && $pagina> 0) ? (int) $pagina : 1;

     $inicio = ($pagina> 0) ? (($pagina*$registros)-$registros) : 0 ;

     if(isset($busqueda) && $busqueda != "") {

         $consulta_datos ="SELECT * FROM t_servicio WHERE ((nombre_servicio LIKE '%$busqueda%')) LIMIT $inicio ,$registros";

         $consulta_total ="SELECT COUNT(id_servicio ) FROM t_servicio WHERE ((nombre_servicio LIKE '%$busqueda%'))";

     }else{
         $consulta_datos ="SELECT * FROM t_servicio  LIMIT $inicio ,$registros";

         $consulta_total ="SELECT COUNT(id_servicio ) FROM t_servicio ";
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
                                 <th class="has-text-centered">Nombre Tipo servicio</th>
                                 <th class="has-text-centered" colspan="2">Opciones</th>
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
                     <td>'.$fila['nombre_servicio'].'</td>
                     <td>
                         <a href="'.APP_URL.'actualizarTipoServicio/'.$fila['id_servicio'].'/" class="button is-success is-rounded is-small">Actualizar</a>
                     </td>
                     <td>
                         <form class="FormularioAjax" action="'.APP_URL.'app/ajax/GiroAjax.php" method="POST" autocomplete="off" >

                             <input type="hidden" name="modulo_tipo_servicio" value="eliminar">
                             <input type="hidden" name="id_tipo_servicio" value="'.$fila['id_servicio'].'">

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
         $tabla.='<p class="has-text-right">Mostrando tipos de servicio <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
         if($pagina == 0 ){
             $pagina = 1 ;
         }
         $tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7); 
     }

        return $tabla;
    }

    public function listarTipoServicio(){

        $select ="";
        $consulta_datos ="SELECT * FROM t_servicio_tipo";
    
    
        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();
        $select.=' <div class="columns">
                    <div class="column">
                        <label>Tipo Servicio</label>
                        <div class="select" style="width: 100%;">
                            <select name="id_tipo" id="id_tipo" style="width: 100%;">';
        foreach($datos as $fila){
            $select.=' <option value="'.$fila['id_tipo_servicio'].'">'.$fila['nombre_tipo'].'</option>';
        }
        $select.='        </select>
                        </div>
                    </div>
                </div>';
        return $select;
       }
}
