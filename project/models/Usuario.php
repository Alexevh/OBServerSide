<?php
namespace models;
use model\Model;
use patterns\ServiceLocator;

class Usuario extends Model{
    
    public $id = null;
    public $nombre = null;
    public $apellido = null;
    public $email = null;
    public $telefono = null;
    public $status = null;
    
}