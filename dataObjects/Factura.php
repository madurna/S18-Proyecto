<?php
/**
 * Table Definition for factura
 */
require_once 'DB/DataObject.php';

class DataObjects_Factura extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'factura';             // table name
    public $factura_id;                      // int(11)  not_null primary_key auto_increment group_by
    public $factura_fecha_generacion;        // date(10)  not_null
    public $factura_fecha_vencimiento;       // date(10)  not_null
    public $factura_numero;                  // int(11)  not_null group_by
    public $factura_cliente_id;              // int(11)  not_null multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
