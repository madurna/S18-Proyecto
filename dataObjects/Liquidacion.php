<?php
/**
 * Table Definition for liquidacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Liquidacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'liquidacion';         // table name
    public $liquidacion_id;                  // int(11)  not_null primary_key auto_increment group_by
    public $liquidacion_empresa_id;          // int(11)  not_null multiple_key group_by
    public $liquidacion_mes;                 // int(11)  not_null group_by
    public $liquidacion_anio;                // int(11)  not_null group_by
    public $liquidacion_estado_id;           // int(11)  not_null multiple_key group_by
    public $liquidacion_archivo_id;          // int(11)  not_null multiple_key group_by

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Liquidacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
