<?php
/**
 * Table Definition for cuota
 */
require_once 'DB/DataObject.php';

class DataObjects_Cuota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cuota';               // table name
    public $cuota_id;                        // int(11)  not_null primary_key auto_increment group_by
    public $cuota_descripcion;               // varchar(200)  not_null
    public $cuota_fecha_vencimiento;         // datetime(19)  not_null
    public $cuota_monto;                     // float(12)  not_null group_by
    public $cuota_numero;                    // int(11)  not_null group_by
    public $cuota_porcentaje_recargo;        // float(12)  not_null group_by
    public $cuota_unidad_funcional_id;       // int(11)  not_null multiple_key group_by
    public $cuota_movimiento_id;             // int(11)  not_null multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
