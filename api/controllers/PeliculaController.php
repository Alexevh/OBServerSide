<?php

use rest\controller\Rest;
use models\Pelicula;
use patterns\ServiceLocator;

class PeliculaController extends Rest {

    public function postAction() {

        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');

        try {
            /* Recibo los parametros del cliente */
            $tituloPelicula = $this->getParam("tituloPelicula");
            $anioPelicula = $this->getParam("anioPelicula");
            $categoriaPelicula = $this->getParam("categoriaPelicula");
            $descripcionPelicula = $this->getParam("descripcionPelicula");


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

}
