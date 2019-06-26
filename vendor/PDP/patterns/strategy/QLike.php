<?php
namespace patterns\strategy;
use patterns\strategy\QueryAbstract;

class QLike extends QueryAbstract{
	
	public function __construct($campo, $valor, $and=true){
		if(is_array($campo) && !empty($campo)){
			$this->conditions = $campo;
		}
		elseif(!is_null($campo) && !is_null($valor)){
			$this->conditions[$campo] = $valor;
		}
                
                $this->operador = ($and)?' AND':' OR ';
	}
	//Ej:
	//QLike = new QLike('nombre','juan') o 
	//QLike = new QLike(array('nombre'=>'juan','appellido'=>'perez')
	
	//Q es el cliente en el strategy
	public function preparar($Q, $pos = 0){
		$result = null;
		if(is_array($this->conditions) && !empty($this->conditions)){
			//recorro campo,valor, en vez de and hardcoded uso this->operador
			foreach($this->conditions as $field=>$value){
				$result .= "AND $field LIKE ?";
				$Q->binds[] = "%$value%";
			}
		//si es el primero no utilizo el primer AND
		$result = ($pos == 0)?substr($result, 4):$result;
		//si es la primer sentencia escribe el WHERE
		$result = (is_null($Q->query))?" WHERE $result":$result;
		}
		//le agrego a Q esta sentencia de consulta
		$Q->query .= $result;
               //die(print_r($result));
	}
}