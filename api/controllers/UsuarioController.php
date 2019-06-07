<?php

use rest\controller\Rest;
use models\Usuario;
use patterns\ServiceLocator;

class UsuarioController extends Rest {
    /* El index del REST nos lista los productos */

    public function indexAction() {
        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');

        try {


            /* Creo una instancia de la clase Config */
            $Config = new Zend_Config_Ini(APP . DS . 'config' . DS . "config.ini", APPLICATION_ENV);
            /* Vamos a devolver un formato JSON */
            //$resultado = array("status"=>1000, "descripcion"=>"Hola");       
            /* Esta es otra forma de crear el array con las claves que quiero */
            $resultado["status"] = 1000;
            $resultado["descripcion"] = "hola estoy en el usuario controler indice";
            /* Conviero el array a JSON */
            $resultado = Zend_Json::encode($resultado);
            /* Con instancia de response envio el cuerpo del mensaje */
            exit($this->getResponse()->appendBody($resultado));
        } catch (exception $e) {
            $this->getResponse()->setHttpResponseCode($e->getCode());
            $resultado["status"] = 1;
            $resultado["descripcion"] = $e->getMessage();
            $resultado = Zend_Json::encode($resultado);
            exit($this->getResponse()->appendBody($resultado));
        }
    }

    /* Vamos a recibir parametros para crear un producto */

    public function postAction() {

        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');

        try {
            /* Recibo los parametros del cliente */
            $nombreUsuario = $this->getParam("nombreUsuario");
            $emailUsuario = $this->getParam("emailUsuario");
            $apellidoUsuario = $this->getParam("apellidoUsuario");
            $telefonoUsuario = $this->getParam("telefonoUsuario");
            $statusUsuario = $this->getParam("statusUsuario");

            /* Seteo el lenguaje */
            $lang = $this->lang;
            $Translator = ServiceLocator::getTranslator($lang);

            /* me fijo que no este vacio el parametro nombre */
            if (empty($nombreUsuario)) {
                throw new Exception($Translator->_("error_campo_vacio_nombre"), 409);
                /* Preguntar al docente por que no funciona */
            }
            /* me fijo que no este vacio el parametro email */
            if (empty($emailUsuario)) {
                throw new Exception($Translator->_("error_campo_vacio_email"), 409);
                /* Preguntar al docente por que no funciona */
            }

            if (empty($apellidoUsuario)) {
                throw new Exception($Translator->_("error_campo_vacio_apellido"), 409);
                /* Preguntar al docente por que no funciona */
            }

            if (empty($telefonoUsuario)) {
                throw new Exception($Translator->_("error_campo_vacio_telefono"), 409);
                /* Preguntar al docente por que no funciona */
            }

            if (empty($statusUsuario)) {

                $statusUsuario = "INACTIVO";
            }

            $Usuario = new Usuario();
            $Usuario->nombre = $nombreUsuario;
            $Usuario->apellido = $apellidoUsuario;
            $Usuario->email = $emailUsuario;
            $Usuario->telefono = $telefonoUsuario;
            $Usuario->status = $statusUsuario;
            $Usuario->create();

            /* Devolvemos en JSON el OK */

            $resultado["status"] = 1000;
            $resultado["descripcion"] = " Se dio de alta correctamente a $nombreUsuario $apellidoUsuario";
            /* Conviero el array a JSON */
            $resultado = \Zend_Json::encode($resultado);
            exit($this->getResponse()->appendBody($resultado));
        } catch (Exception $e) {
            die($e->getMessage());
            $this->error($e);
        }
    }

}
