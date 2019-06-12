<?php
namespace dao;
use patterns\ServiceLocator;


class Dao {
    
    public $DataAccess = null;
    
    public function __construct() {
        $Config = ServiceLocator::getConfig();
        $this->DataAccess=DataAccess::getInstance($Config);
    }
    
    public function create($Model)
    {
        $binds= array();
        foreach($Model->toArray() as $atributo=>$valor){
            /* solo grabe datos escalares, ni arrays ni objetos*/
            if (!is_object($valor))
            {
                $binds[$atributo]=$valor;
            }
        }
        
        $reflect = new \ReflectionClass($Model);
        /* por ejemplo tabla device*/
        $tabla =  strtolower($reflect->getShortName());
        
        try { 
          
            //die("llegue aca")
            print_r($binds);
         $this->DataAccess->insert($tabla, $binds);
         $Model->id = $this->DataAccess->lastInsertId($tabla, 'id');
            
        } catch (\Exception $e)
        {
            //$Translator = ServiceLocator::getTranslator();
            /* log del error en el archivo errores*/
            throw new \Exception("Hubo un error al insertar ".$e->getMessage());
        }
        
    }
}

