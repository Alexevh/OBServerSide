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

class RankingController extends rest{
    
    public function indexAction() {
        
      
        $Pelicula = new Pelicula();
        $fechadehoy =Date("Y");    
        $resultado = $Pelicula->obtenerRanking($fechadehoy);
       
         /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        //die(" me llego".$Q);
        $respuesta = array("status"=>0, "descripcion"=>$resultado);
        //die(print_r($Device->hola()));
         //$respuesta = array("status"=>0, "descripcion"=>$Pelicula->consulta("ISH"));
         $this->response($respuesta, 200);
        
        
       

    }
}