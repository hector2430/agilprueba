<?php 

    namespace app\controllers;
    use app\models\viewsModel;

    class viewsController extends viewsModel{

        public function obtenerVistasControllador($vista){
            if($vista != ""){
                $respuesta = $this->obtnerVistasModelo($vista);
            }else{
                $respuesta ="login";
            }
            return $respuesta;
        }
    }
?>