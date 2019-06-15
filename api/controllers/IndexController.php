<?php

use patterns\ServiceLocator;

/* Controlador por defecto. */

class IndexController extends Zend_Rest_Controller {
    /* El index del REST nos lista los productos */

    public function indexAction() {
        noImplementado();
    }

    public function postAction() {
        //die("la concha");
        noImplementado();
    }

    public function putAction() {
        noImplementado();
    }

    public function deleteAction() {
        noImplementado();
    }

    public function getAction() {


        noImplementado();
    }

    public function headAction() {
        noImplementado();
    }

    public  function noImplementado() {
         /* Seteo el lenguaje */
        $lang = $this->lang;
        $Translator = ServiceLocator::getTranslator($lang);
        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        //die(" me llego".$Q);
        //$error = $Translator->_(("error_no_implementado"), 409);
        $respuesta = array("status" => 0, "descripcion" => $Translator->_("error_no_implementado"));
        //die(print_r($Device->hola()));
        //$respuesta = array("status"=>0, "descripcion"=>$Pelicula->consulta("ISH"));
        $this->response($respuesta, 200);
    }

}
