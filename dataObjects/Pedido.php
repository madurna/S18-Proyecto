<?php
/**
 * Table Definition for pedido
 */
require_once 'DB/DataObject.php';

class DataObjects_Pedido extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'pedido';              // table name
    public $pedido_id;                       // int(11)  not_null primary_key auto_increment group_by
    public $pedido_estado;                   // varchar(45)  not_null
    public $pedido_fecha;                    // datetime(19)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pedido',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
