<?php

namespace app\Controllers;

use app\Models\mainModel;

class giroController extends mainModel{

    public function registrarGiroController() {
     #guardardatos
     $codigo= $this->limpiarCadena($_POST["giro_cod"]);
     $nombre= $this->limpiarCadena($_POST["nombre_giro"]);
    

     if($codigo == "" || $nombre == ""){

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
     if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $codigo)){

         $alerta= [
             "tipo" => "simple",
             "titulo" =>"Ha ocurrido un error",
             "texto" => "El campo nombre no posee el formato solicitado",
             "icono" => "error",
         ];
         return json_encode($alerta);
         exit();
     }
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

    
     $giro_datos_reg= [
         [
             "campo_nombre" => "Giro_Codigo",
             "campo_marcador" => ":cod",
             "campo_valor" => $codigo,

         ],
         [
             "campo_nombre" => "Nombre",
             "campo_marcador" => ":nombre",
             "campo_valor" => $nombre,
         ]

     ];
 
     $registrarGiro = $this->guardarDatos("t_giro",$giro_datos_reg);
     
     if($registrarGiro->rowCount() ==1 ){
         $alerta= [
             "tipo" => "limpiar",
             "titulo" =>"Giro Registrado",
             "texto" => "El giro ". $nombre ." ha sido registrado correctamente",
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
 public function listarGiroController($pagina,$registros,$url,$busqueda){
     
     $pagina= $this->limpiarCadena($pagina);
     $registros= $this->limpiarCadena($registros);
     $pagina= $this->limpiarCadena($url);
   
     $url =APP_URL.$url."/";

     $busqueda= $this->limpiarCadena($busqueda);
     $tabla ="";

     $pagina = (isset($pagina) && $pagina> 0) ? (int) $pagina : 1;

     $inicio = ($pagina> 0) ? (($pagina*$registros)-$registros) : 0 ;

     if(isset($busqueda) && $busqueda != "") {

         $consulta_datos ="SELECT * FROM t_giro WHERE ((Nombre LIKE '%$busqueda%'  OR Giro_Codigo LIKE '%$busqueda%' )) LIMIT $inicio ,$registros";

         $consulta_total ="SELECT COUNT(Giro_Codigo ) FROM t_giro WHERE ((Nombre LIKE '%$busqueda%' OR Giro_Codigo LIKE '%$busqueda%'))";

     }else{
         $consulta_datos ="SELECT * FROM t_giro  LIMIT $inicio ,$registros";

         $consulta_total ="SELECT COUNT(Giro_Codigo ) FROM t_giro ";
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
                                 <th class="has-text-centered">Código Giro</th>
                                 <th class="has-text-centered">Nombre Cuenta</th>
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
                     <td>'.$fila['Giro_Codigo'].'</td>
                     <td>'.$fila['Nombre'].'</td>
                     <td>
                         <a href="'.APP_URL.'actualizarGiro/'.$fila['Giro_Codigo'].'/" class="button is-success is-rounded is-small">Actualizar</a>
                     </td>
                     <td>
                         <form class="FormularioAjax" action="'.APP_URL.'app/ajax/GiroAjax.php" method="POST" autocomplete="off" >

                             <input type="hidden" name="modulo_giro" value="eliminar">
                             <input type="hidden" name="giro_id" value="'.$fila['Giro_Codigo'].'">

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
}