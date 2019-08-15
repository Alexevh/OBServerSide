<?php

use rest\controller\Rest;
use models\Usuario;
use patterns\ServiceLocator;


//Consultas
use patterns\strategy\Query;
use patterns\strategy\QAnd;
use patterns\strategy\QueryAbstract;
use patterns\strategy\QLike;

class UsuarioController extends Rest {
    /* El index del REST nos lista los productos */



    /* Vamos a recibir parametros para crear un producto */

    public function postAction() {

        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');

        try {
            /* Recibo los parametros del cliente */
            $nombreUsuario = $this->getRawParam("nombreUsuario");
            $emailUsuario = $this->getRawParam("emailUsuario");
            $apellidoUsuario = $this->getRawParam("apellidoUsuario");
            $telefonoUsuario = $this->getRawParam("telefonoUsuario");
            $statusUsuario = $this->getRawParam("statusUsuario");
            $paswwordUsuario = $this->getRawParam("passwordUsuario");

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
            
            if (!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("$emailUsuario ES INVALIDO", 409);
           
            }
            
          

            $Usuario = new Usuario();
            
              if ($Usuario->ValidarExisteCampo("email",$emailUsuario))
            {
                throw new Exception("$emailUsuario  ya esta en nuestra base de datos", 409);
            } else if ($Usuario->ValidarExisteCampo("telefono",$telefonoUsuario)){
                 throw new Exception("$telefonoUsuario  ya esta en nuestra base de datos", 409);
            }
            
            
            $Usuario->nombre = $nombreUsuario;
            $Usuario->apellido = $apellidoUsuario;
            $Usuario->email = $emailUsuario;
            $Usuario->telefono = $telefonoUsuario;
            $Usuario->status = $statusUsuario;
            $Usuario->password= $paswwordUsuario;
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
    
    
    public function putAction() {
        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        
        try {
            
             $id = $this->getRawParam("id");
             /* Recibo los parametros del cliente */
            $nombreUsuario = $this->getRawParam("nombreUsuario");
            $emailUsuario = $this->getRawParam("emailUsuario");
            $apellidoUsuario = $this->getRawParam("apellidoUsuario");
            $telefonoUsuario = $this->getRawParam("telefonoUsuario");
            $statusUsuario = $this->getRawParam("statusUsuario");
             
            $Usuario = new Usuario();
            
            /* Cargo la query*/
           
            $Q = new Query($Usuario);
            $Q->add(new QAnd("id", $id));
            
            /* Esto carga el device por el ID valido de la BD, el id lo tiene*/
            if (!$Usuario->load($Q))
            {
                throw new \Exception("id no valida");
            }
            
            
            
            $Usuario->nombre = $nombreUsuario;
            $Usuario->apellido = $apellidoUsuario;
            $Usuario->email = $emailUsuario;
            $Usuario->telefono = $telefonoUsuario;
            $Usuario->status = $statusUsuario;
            $Usuario->updated = Date("Y-m-m h:m:s");
            $Usuario->update();
            $respuesta = array("status" => 0, "descripcion" => "Modificado correctamente");


            $this->response($respuesta, 200);
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

            $Usuario = new Usuario();
            
            /* Cargo la query*/
            $Q = new Query($Usuario);
            $Q->add(new Qand("id", $id));
            
            /* Esto carga el device por el ID valido de la BD, el id lo tiene*/
            if (!$Usuario->load($Q))
            {
                throw new \Exception("Status no valido");
            }
            
            $respuesta = array("status" => 0, "descripcion" => $Usuario->toArray());


            $this->response($respuesta, 200);
        } catch (Exception $e) {
            $this->error($e);
        }
    }

}
