<?php
/**
 * Table Definition for persona_localidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Persona_localidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'persona_localidad';    // table name
    public $id;                              // int(11)  not_null primary_key auto_increment group_by
    public $descripcion;                     // varchar(200)  not_null
    public $fecha;                           // datetime(19)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Persona_localidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
