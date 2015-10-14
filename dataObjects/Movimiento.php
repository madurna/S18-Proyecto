<?php
/**
 * Table Definition for movimiento
 */
require_once 'DB/DataObject.php';

class DataObjects_Movimiento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'movimiento';          // table name
    public $movimiento_id;                   // int(11)  not_null primary_key auto_increment group_by
    public $material_descripcion;            // varchar(200)  not_null
    public $material_fecha;                  // datetime(19)  not_null
    public $material_monto;                  // float(12)  not_null group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Movimiento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
