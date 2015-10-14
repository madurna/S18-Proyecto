<?php
/**
 * Table Definition for avance_tarea
 */
require_once 'DB/DataObject.php';

class DataObjects_Avance_tarea extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'avance_tarea';        // table name
    public $avance_tarea_id;                 // int(11)  not_null primary_key auto_increment group_by
    public $avance_tarea_avance_id;          // int(11)  not_null multiple_key group_by
    public $avance_tarea_tarea_id;           // int(11)  not_null multiple_key group_by
    public $avance_tarea_fecha;              // date(10)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Avance_tarea',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
