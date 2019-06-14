<?php

class Pelicula extends Dao {

    public $id = null;
    public $titulo = null;
    public $descripcion = null;
    public $anio = null;
    public $categoria = null;
    
    
    public function consultaRanking($anio) {
        $sql = " SELECT device.*, cliente.nombre, cliente.apellido
FROM device
LEFT JOIN cliente ON cliente.id = device.cliente
WHERE modelo LIKE ? ";
        $binds = array("%$modelo%");
        //die($sql);
        return $this->DataAccess->retrieve($sql, $binds)->fetchAll();
    }

}
