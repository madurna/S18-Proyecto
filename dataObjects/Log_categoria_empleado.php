<?php
/**
 * Table Definition for log_categoria_empleado
 */
require_once 'DB/DataObject.php';

class DataObjects_Log_categoria_empleado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'log_categoria_empleado';    // table name
    public $log_categoria_empleado_id;       // int(11)  not_null primary_key auto_increment group_by
    public $log_categoria_empleado_categoria_anterior_id;    // varchar(200)  not_null
    public $log_categoria_empleado_anio;     // int(4)  not_null group_by
    public $log_categoria_empleado_mes;      // int(2)  not_null group_by
    public $log_categoria_empleado_empleado_id;    // int(11)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Log_categoria_empleado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
