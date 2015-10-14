<?php
/**
 * Table Definition for gasto_agrupamiento
 */
require_once 'DB/DataObject.php';

class DataObjects_Gasto_agrupamiento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'gasto_agrupamiento';    // table name
    public $gasto_agrupamiento_id;           // int(11)  not_null primary_key auto_increment group_by
    public $gasto_agrupamiento_descripcion;    // varchar(45)  not_null
    public $gasto_agrupamiento_tipo_gasto_id;    // int(11)  not_null multiple_key group_by
    public $gasto_agrupamiento_baja;         // tinyint(4)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Gasto_agrupamiento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	function get_gastos_agrupamientos(){
		$this -> orderby('gasto_agrupamiento_descripcion ASC');
		$this ->find();
		while($this->fetch()){
			$gasto_agrupamiento[$this->gasto_agrupamiento_id] = $this-> gasto_agrupamiento_descripcion;
		}
		return $gasto_agrupamiento;
	}
}
