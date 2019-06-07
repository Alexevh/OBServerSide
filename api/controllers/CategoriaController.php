<?php

use rest\controller\Rest;
use models\Categoria;
use patterns\ServiceLocator;

class CategoriaController extends Rest {

    public function postAction() {
        
        /* Vamos a especificar que el tipo de contenido que devolvemos es JSON */
        $this->getResponse()->setHeader('Content-type', 'application/json');
        
        try {
            /* Recibo los parametros del cliente */
            $nombreCategoria = $this->getParam("nombreCategoria");
            
            /* Seteo el lenguaje*/
            $lang = $this->lang;
            $Translator = ServiceLocator::getTranslator($lang);
            
            /* me fijo que no este vacio el parametro nombre*/
            if (empty($nombreCategoria) || $nombreCategoria=="") {
                throw new Exception($Translator->_("error_nombre_categoria"), 409);
                /* Preguntar al docente por que no funciona*/
            }
            
            $Categoria = new Categoria();
            $Categoria->nombre = $nombreCategoria;
            $Categoria->create();
            echo("Se dio de alta $nombreCategoria");
            exit();
            
        }catch (Exception $e)
        {
            die($e->getMessage());
            $this->error($e);
        }
    }

}
