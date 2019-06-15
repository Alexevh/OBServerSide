<?php

namespace rest\controller;
use patterns\ServiceLocator;

class Rest extends \Zend_Rest_Controller {
    
    
    public function getHeader($name)
    {
        return $this->getRequest()->getHeader($name);
    }
    
    public function error(\Exception $e)
    {
        //die($e->getCode());
        $this->getResponse()->setHttpResponseCode($e->getCode());
        $resultado = array("status"=>1, "Descripcion"=>$e->getMessage());
        $resultado = \Zend_Json_Encoder::encode($resultado);
        exit($this->getResponse()->appendBody($resultado));
    }
    
    public function init()
    {
        //die("entra al init "); 
        $this->getResponse()->setHeader('Content-type', 'application/json');  
        $this->lang = $lang = ($this->getHeader("lang"))?$this->getHeader("lang"):"es";
    }
    
    public function getRawParam($name){
        $raw = $this->getRequest()->getRawBody();       
        $raw = \Zend_Json_Decoder::decode($raw); 
        return  $raw[$name];
    }


    /* El index del REST nos lista los productos*/
    public function indexAction() {
           
        
       $this->noImplementado();
    }
    
    public function postAction() {
       $this->noImplementado();
    }
    
    public function putAction() {
        $this->getResponse()->setHeader('Content-type', 'application/json');   
       
        $this->getResponse()->setHttpResponseCode(404);
        $response = array("status"=>0, "descripcion"=>"No se puede poner");
        $response = \Zend_Json_Encoder::encode($response);
        exit($this->getResponse()->appendBody($response));
    }
    
    public function deleteAction() {
         $this->noImplementado();
         
          
    }
     public function getAction() {
         
         
         $this->noImplementado();
          
    }
    
     public function headAction() {
       $this->noImplementado();
          
    }
    
    public function response($response, $httpcode)
    {
        //$CODIGO = $httpcode;
        //die("me llego el cod".$httpcode);
        $this->getResponse()->setHttpResponseCode($httpcode);   
        $respuesta = \Zend_Json::encode($response);
        exit($this->getResponse()->appendBody($respuesta));
        
    }
    
        public   function noImplementado() {
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
