<?php
/**
 * Table Definition for ajuste
 */
require_once 'DB/DataObject.php';

class DataObjects_Ajuste extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ajuste';              // table name
    public $ajuste_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $ajuste_descripcion;              // varchar(200)  not_null
    public $ajuste_porcentaje;               // float(12)  not_null group_by
    public $ajuste_fecha;                    // date(10)  not_null
    public $ajuste_monto;                    // double(20)  not_null group_by
    public $ajuste_obra_civil_id;            // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ajuste',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
