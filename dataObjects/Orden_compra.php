<?php
/**
 * Table Definition for orden_compra
 */
require_once 'DB/DataObject.php';

class DataObjects_Orden_compra extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'orden_compra';        // table name
    public $orden_compra_id;                // int(11) not_null primary_key auto_increment group_by
    public $orden_compra_estado;            // int(11) not_null multiple_key group_by
    public $orden_compra_usuario_id;        // int(11) not_null multiple_key group_by

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
