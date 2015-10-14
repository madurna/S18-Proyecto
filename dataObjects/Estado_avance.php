<?php
/**
 * Table Definition for estado_avance
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado_avance extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado_avance';       // table name
    public $estado_avance_id;                // int(11)  not_null primary_key auto_increment group_by
    public $estado_avance_descripcion;       // varchar(50)  not_null
    public $estado_avance_baja;              // tinyint(4)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estado_avance',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
