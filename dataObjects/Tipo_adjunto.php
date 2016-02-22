<?php
/**
 * Table Definition for tipo_adjunto
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipo_adjunto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipo_adjunto';        // table name
    public $tipo_adjunto_id;                // int(11) not_null primary_key auto_increment group_by
    public $tipo_adjunto_nombre;            // varchar(45) not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function get_tipos_adjunto(){
    	$tipos_adjunto = array();
    	$tipos_adjunto['Seleccione'] = 'Seleccione';
    	//$this -> orderBy('tipo_adjunto_nombre ASC');
    	$this -> find();
    	while ($this -> fetch()){
    		$tipos_adjunto[$this -> tipo_adjunto_id] = $this -> tipo_adjunto_nombre;
    	}
    	return $tipos_adjunto;
    }
}
