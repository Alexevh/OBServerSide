<?php
use rest\controller\Rest;
use models\Pelicula;
use models\Log;
use patterns\ServiceLocator;

//Consultas
use patterns\strategy\Query;
use patterns\strategy\QAnd;
use patterns\strategy\QueryAbstract;
use patterns\strategy\QLike;

class LogController extends rest{
    
    public function postAction() {
        
        //Si viene por body json uso getRawParam, si viene por URL getparam
        $pelicula = $this->getParam("pelicula");
        $usuario = $this->getParam("usuarioid");
        
        $log = new Log();
        $log->pelicula=$pelicula;
        $log->usuario=$usuario;
        $log->created=Date("Y-m-m h:m:s");
        $log->create();
        
        //$RESULTADO = $Device->hola();

         /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        //die(" me llego".$Q);
        $respuesta = array("status"=>0, "descripcion"=>$log->toArray());
        //die(print_r($Device->hola()));
         //$respuesta = array("status"=>0, "descripcion"=>$Pelicula->consulta("ISH"));
         $this->response($respuesta, 200);
        
        
       

    }
}