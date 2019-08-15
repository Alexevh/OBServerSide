<?php
namespace daos;

use model\Model;
use patterns\ServiceLocator;
use dao\Dao;

class Usuario extends Dao{
    
    public $id = null;
    public $nombre = null;
    public $apellido = null;
    public $email = null;
    public $telefono = null;
    public $status = null;
    public $password = null;
    
    
    public function ValidarExisteCampo($campo, $valor){
        
        $sql = "select * from usuario where $campo = ?";
        $binds = array("$valor");
        //die($sql);
        if($this->DataAccess->retrieve($sql, $binds)->fetch())
        {
            return true;
        } else {
            return false;
        }
        
        
    }
}