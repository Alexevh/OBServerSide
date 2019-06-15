<?php

use rest\controller\Rest;
use models\Categoria;
use patterns\ServiceLocator;
//Consultas
use patterns\strategy\Query;
use patterns\strategy\QAnd;
use patterns\strategy\QueryAbstract;
use patterns\strategy\QLike;

class CategoriaController extends Rest {

    public function indexAction() {
        //Si viene por body json uso getRawParam, si viene por URL getparam

        $Categoria = new Categoria();

        $Q = new Query($Categoria);

        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        //die(" me llego".$Q);
        $respuesta = array("status" => 0, "descripcion" => $Categoria->fetch($Q));
        //die(print_r($Device->hola()));
        //$respuesta = array("status"=>0, "descripcion"=>$Pelicula->consulta("ISH"));
        $this->response($respuesta, 200);
    }

    public function postAction() {

        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');

        try {
            /* Recibo los parametros del cliente */
            $nombreCategoria = $this->getParam("nombreCategoria");

            /* Seteo el lenguaje */
            $lang = $this->lang;
            $Translator = ServiceLocator::getTranslator($lang);

            /* me fijo que no este vacio el parametro nombre */
            if (empty($nombreCategoria) || $nombreCategoria == "") {
                throw new Exception($Translator->_("error_nombre_categoria"), 409);
                /* Preguntar al docente por que no funciona */
            }

            $Categoria = new Categoria();
            $Categoria->nombre = $nombreCategoria;
            $Categoria->create();
            echo("Se dio de alta $nombreCategoria");
            exit();
        } catch (Exception $e) {
            die($e->getMessage());
            $this->error($e);
        }
    }

}
