<?php

use rest\controller\Rest;
use models\Pelicula;
use patterns\ServiceLocator;

//Consultas
use patterns\strategy\Query;
use patterns\strategy\QAnd;
use patterns\strategy\QueryAbstract;
use patterns\strategy\QLike;

class PeliculaController extends Rest {
    
    
      public function indexAction() {
        
        //Si viene por body json uso getRawParam, si viene por URL getparam
        $categoria = $this->getRawParam("categoria");
        $titulo = $this->getRawParam("titulo");
        $ranking = $this->getRawParam("ranking");
        $Pelicula = new Pelicula();
        //$RESULTADO = $Device->hola();
        
        if (!empty($categoria))
        {
            $Q = new Query($Pelicula);
            $Q->add(new Qand("categoria", $categoria));
      
        }
        
        
        if (!empty($titulo))
        {
            //
            $Q = new Query($Pelicula);
            $Q->add(new QLike("titulo", $titulo));
            //die(" me llego".$titulo);
        }
         /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        //die(" me llego".$Q);
        $respuesta = array("status"=>0, "descripcion"=>$Pelicula->fetch($Q));
        //die(print_r($Device->hola()));
         //$respuesta = array("status"=>0, "descripcion"=>$Pelicula->consulta("ISH"));
         $this->response($respuesta, 200);
        
        
       

    }


    
        public function putAction() {
        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        
        try {
            
             $id = $this->getRawParam("id");
             /* Recibo los parametros del cliente */
            $tituloPelicula = $this->getRawParam("tituloPelicula");
            $anioPelicula = $this->getRawParam("anioPelicula");
            $categoriaPelicula = $this->getRawParam("categoriaPelicula");
            $descripcionPelicula = $this->getRawParam("descripcionPelicula");
             
            $Pelicula = new Pelicula();
            
            /* Cargo la query*/
           
            $Q = new Query($Pelicula);
            $Q->add(new QAnd("id", $id));
            
            /* Esto carga el device por el ID valido de la BD, el id lo tiene*/
            if (!$Pelicula->load($Q))
            {
                throw new \Exception("id no valida");
            }
            
            
            
            $Pelicula->titulo = $tituloPelicula;
            $Pelicula->categoria = $categoriaPelicula;
            $Pelicula->anio = $anioPelicula;
            $Pelicula->descripcion = $descripcionPelicula;
            
            $Pelicula->id=$id;
            $Pelicula->updated = Date("Y-m-m h:m:s");
            $Pelicula->update();
            $respuesta = array("status" => 0, "descripcion" => array());


            $this->response($respuesta, 209);
        } catch (Exception $e) {
            $this->error($e);
        }
    }
    
    
     public function getAction() {
       
           /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');

        try {

            $lang = $this->lang;
            $Translator = ServiceLocator::getTranslator($lang);


            $id = $this->getParam("id");
            //die("me llego ".$id);
            if (empty($id)) {
                throw new \Exception($Translator->_("invalid_id", 409));
            }

            $Pelicula = new Pelicula();
            
            /* Cargo la query*/
            $Q = new Query($Pelicula);
            $Q->add(new Qand("id", $id));
            
            /* Esto carga el device por el ID valido de la BD, el id lo tiene*/
            if (!$Pelicula->load($Q))
            {
                throw new \Exception("Status no valido");
            }
            
            $respuesta = array("status" => 0, "descripcion" => $Pelicula->toArray());


            $this->response($respuesta, 200);
        } catch (Exception $e) {
            $this->error($e);
        }
    }
    
    
}
