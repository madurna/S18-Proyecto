<?php
/**
 * Table Definition for pedido_herramienta
 */
require_once 'DB/DataObject.php';

class DataObjects_Pedido_herramienta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'pedido_herramienta';    // table name
    public $pedido_herramienta_id;           // int(11)  not_null primary_key auto_increment group_by
    public $pedido_herramienta_cantidad;     // int(11)  not_null group_by
    public $pedido_herramienta_descripcion;    // varchar(200)  not_null
    public $pedido_herramienta_herramienta_id;    // int(11)  not_null multiple_key group_by
    public $pedido_herramienta_pedido_id;    // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pedido_herramienta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
