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

    public function postAction() {

        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');

        try {
            /* Recibo los parametros del cliente */
            $tituloPelicula = $this->getRawParam("tituloPelicula");
            $anioPelicula = $this->getRawParam("anioPelicula");
            $categoriaPelicula = $this->getRawParam("categoriaPelicula");
            $descripcionPelicula = $this->getRawParam("descripcionPelicula");


            /* Seteo el lenguaje */
            $lang = $this->lang;
            $Translator = ServiceLocator::getTranslator($lang);

            /* me fijo que no este vacio el parametro nombre */
            if (empty($tituloPelicula)) {
                throw new Exception($Translator->_("error_campo_vacio_titulo"), 409);
                /* Preguntar al docente por que no funciona */
            }
            /* me fijo que no este vacio el parametro email */
            if (empty($anioPelicula)) {
                throw new Exception($Translator->_("error_campo_vacio_anio"), 409);
                /* Preguntar al docente por que no funciona */
            }

            if (empty($categoriaPelicula)) {
                throw new Exception($Translator->_("error_campo_vacio_categoria"), 409);
                /* Preguntar al docente por que no funciona */
            }

            if (empty($descripcionPelicula)) {
              $descripcionPelicula = "SIN DESCRIPCION";
            }


            $Pelicula = new Pelicula();
            $Pelicula->titulo = $tituloPelicula;
            $Pelicula->categoria = $categoriaPelicula;
            $Pelicula->anio = $anioPelicula;
            $Pelicula->descripcion = $descripcionPelicula;

            $Pelicula->create();

            /* Devolvemos en JSON el OK */

            $resultado["status"] = 1000;
            $resultado["descripcion"] = " Se dio de alta correctamente a $tituloPelicula en l;a categoria  $categoriaPelicula";
            /* Conviero el array a JSON */
            $resultado = \Zend_Json::encode($resultado);
            exit($this->getResponse()->appendBody($resultado));
        } catch (Exception $e) {
            die($e->getMessage());
            $this->error($e);
        }
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
