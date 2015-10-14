<?php
/**
 * Table Definition for tarea_hito
 */
require_once 'DB/DataObject.php';

class DataObjects_Tarea_hito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tarea_hito';          // table name
    public $tarea_hito_id;                   // int(11)  not_null primary_key auto_increment group_by
    public $tarea_hito_tarea_id;             // int(11)  not_null multiple_key group_by
    public $tarea_hito_hito_id;              // int(11)  not_null multiple_key group_by
    public $tarea_hito_fecha;                // date(10)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tarea_hito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
