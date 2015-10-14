<?php
/**
 * Table Definition for asistencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Asistencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'asistencia';          // table name
    public $asistencia_id;                   // int(11)  not_null primary_key auto_increment group_by
    public $asistencia_estado;               // char(1)  not_null
    public $asistencia_fecha;                // date(10)  not_null
    public $asistencia_obrero_id;            // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Asistencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
