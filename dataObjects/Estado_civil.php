<?php
/**
 * Table Definition for estado_civil
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado_civil extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado_civil';        // table name
    public $estado_civil_id;                 // int(11)  not_null primary_key auto_increment group_by
    public $estado_civil_nombre;             // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estado_civil',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('estado_civil_nombre');

    // Esta función crea un vector con el nombre de las estado_civil y
	// el ítem 'TODAS' al principio del arreglo.
	function get_estado_civil_todos(){
		$this -> orderby('estado_civil_nombre ASC');
		$this ->find();
		$estado_civil['Todas'] = 'TODOS';
		while($this->fetch()){
			$estado_civil[$this->estado_civil_id] = $this-> estado_civil_nombre;
		}
	return $estado_civil;
	}
}
