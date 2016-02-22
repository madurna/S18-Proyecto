<?php
/**
 * Table Definition for estudio_alcanzado
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudio_alcanzado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudio_alcanzado';    // table name
    public $estudio_id;                     // int(11) not_null primary_key auto_increment group_by
    public $estudio_nombre;                 // varchar(200) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('estudio_nombre');

    // Esta función crea un vector con el nombre de las estudio_alcanzado y
	// el ítem 'TODAS' al principio del arreglo.
	function get_estudio_todos(){
		$this -> orderby('estudio_nombre ASC');
		$this ->find();
		$estudio['Todas'] = 'TODOS';
		while($this->fetch()){
			$estudio[$this->estudio_id] = $this-> estudio_nombre;
		}
	return $estudio;
	}

}
