<?php
/**
 * Table Definition for estado_pedido_compra
 */
require_once 'DB/DataObject.php';

class DataObjects_Estado_pedido_compra extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estado_pedido_compra';    // table name
    public $estado_pedido_compra_id;         // int(11)  not_null primary_key auto_increment group_by
    public $estado_pedido_compra_descripcion;    // varchar(50)  not_null
    public $estado_pedido_compra_baja;       // tinyint(1)  not_null group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
