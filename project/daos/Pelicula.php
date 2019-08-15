<?php

namespace daos;

use model\Model;
use patterns\ServiceLocator;
use dao\Dao;

class Pelicula extends Dao {

    public $id = null;
    public $titulo = null;
    public $descripcion = null;
    public $anio = null;
    public $categoria = null;
     public $mapa = '';
    public $foto ='';

    public function obtenerRanking($anio) {

        //die("me llego el ".$anio);
        //$sql = "select  * from pelicula LEFT JOIN log ON log.pelicula = pelicula.id  where year(log.created) = ?";
        $sql = "select  titulo,  count(pelicula.id) as reproducciones from pelicula LEFT JOIN log ON log.pelicula = pelicula.id  where year(log.created) = 2019 group by titulo 
limit 10";
        //$binds = array("$anio");
        $binds = array();
        //die($sql);
        return $this->DataAccess->retrieve($sql, $binds)->fetchAll();
    }

}
