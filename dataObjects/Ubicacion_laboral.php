<?php
/**
 * Table Definition for ubicacion_laboral
 */
require_once 'DB/DataObject.php';

class DataObjects_Ubicacion_laboral extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ubicacion_laboral';    // table name
    public $ubicacion_laboral_id;            // int(11)  not_null primary_key auto_increment group_by
    public $ubicacion_laboral_nombre;        // varchar(200)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ubicacion_laboral',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	public $fb_linkDisplayFields = array('ubicacion_laboral_nombre');

    function get_ubicacion_todos(){
    $this -> orderby('ubicacion_laboral_nombre ASC');
    $this ->find();
    $ubicacion['Todas'] = 'TODOS';
    while($this->fetch()){
        $ubicacion[$this->ubicacion_laboral_id] = $this-> ubicacion_laboral_nombre;
    }
    return $ubicacion;
    }

}
