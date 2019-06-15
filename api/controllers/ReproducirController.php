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

class ReproducirController extends rest{
    
    public function indexAction() {
        
        //Si viene por body json uso getRawParam, si viene por URL getparam
        $pelicula = $this->getRawParam("pelicula");
        $usuario = $this->getRawParam("usuarioid");
        
        if (empty($pelicula) or empty($usuario))
        {
              /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        //die(" me llego".$Q);
        $respuesta = array("status"=>0, "descripcion"=>"hubo un error al reproducir");
        //die(print_r($Device->hola()));
         //$respuesta = array("status"=>0, "descripcion"=>$Pelicula->consulta("ISH"));
         $this->response($respuesta, 200);
        }
        
        
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