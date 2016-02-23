<?php
/**
 * Table Definition for factura_proveedor
 */
require_once 'DB/DataObject.php';

class DataObjects_Factura_proveedor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'factura_proveedor';    // table name
    public $factura_proveedor_id;            // int(11)  not_null primary_key auto_increment group_by
    public $factura_proveedor_fecha;         // datetime(19)  not_null
    public $factura_proveedor_numero;        // int(11)  not_null group_by
    public $factura_proveedor_proveedor_id;    // int(11)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
