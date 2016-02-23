<?php
/**
 * Table Definition for factura_detalle
 */
require_once 'DB/DataObject.php';

class DataObjects_Factura_detalle extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'factura_detalle';     // table name
    public $factura_detalle_id;              // int(11)  not_null primary_key auto_increment group_by
    public $factura_detalle_cantidad;        // int(11)  not_null group_by
    public $factura_detalle_monto;           // float(12)  not_null group_by
    public $factura_detalle_material_id;     // int(11)  not_null multiple_key group_by
    public $factura_detalle_factura_id;      // int(11)  not_null multiple_key group_by
    public $factura_detalle_factura_proveedor_id;    // int(11)  not_null multiple_key group_by
    public $factura_detalle_movimiento_id;    // int(11)  not_null multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
