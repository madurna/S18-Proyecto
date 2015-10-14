<?php
/**
 * Table Definition for detalle_liquidacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalle_liquidacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalle_liquidacion';    // table name
    public $detalle_liquidacion_id;          // int(11)  not_null primary_key auto_increment group_by
    public $detalle_liquidacion_empleado_id;    // int(11)  not_null multiple_key group_by
    public $detalle_liquidacion_concepto_id;    // int(11)  not_null multiple_key group_by
    public $detalle_liquidacion_cantidad;    // decimal(22)  
    public $detalle_liquidacion_monto;       // decimal(22)  not_null
    public $detalle_liquidacion_liquidacion_id;    // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalle_liquidacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
