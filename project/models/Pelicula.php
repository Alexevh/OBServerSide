<?php
namespace models;
use model\Model;
use patterns\ServiceLocator;

class Pelicula extends Model{
    
    public $id = null;
    public $titulo = null;
    public $descripcion = null;
    public $anio = null;
    public $categoria = null;
    public $mapa = '';
    public $foto ='';

     public function obtenerRanking($anio) {
       return  $this->Dao->obtenerRanking($anio);
    }
    
}